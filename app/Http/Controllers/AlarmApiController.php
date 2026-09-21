<?php

namespace App\Http\Controllers;

use App\Models\AlarmLog;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlarmApiController extends Controller
{
    public function poll(Request $request, string $unit): JsonResponse
    {
        $units = config('alarm.units', []);

        if (! array_key_exists($unit, $units)) {
            return response()->json([
                'error' => 'Unit tidak valid. Unit tersedia: ' . implode(', ', array_keys($units)),
            ], 404);
        }

        $unitConfig = $units[$unit];
        $sourceTable = $unitConfig['source_table'];
        $keyColumn = $unitConfig['key_column'];
        $dateColumn = $unitConfig['date_column'];
        $timeColumn = $unitConfig['time_column'] ?? null;
        $infoColumn = $unitConfig['info_column'] ?? null;

        $today = Carbon::today()->toDateString();
        $now = Carbon::now();

        // 1. Anti-join: cari permintaan hari ini yang belum tercatat di alarm_log
        $unrecorded = DB::connection('khanza')
            ->table($sourceTable . ' as p')
            ->leftJoin('alarm_log as a', function ($join) use ($unit, $keyColumn) {
                $join->on('a.kode_permintaan', '=', 'p.' . $keyColumn)
                    ->where('a.jenis', '=', $unit);
            })
            ->whereDate('p.' . $dateColumn, $today)
            ->whereNull('a.id')
            ->select('p.' . $keyColumn . ' as kode_permintaan', 'p.no_rawat')
            ->distinct()
            ->get();

        // 2. Catat baris baru ke alarm_log
        if ($unrecorded->isNotEmpty()) {
            $insertData = [];
            foreach ($unrecorded as $row) {
                $insertData[] = [
                    'jenis' => $unit,
                    'kode_permintaan' => (string) $row->kode_permintaan,
                    'no_rawat' => (string) $row->no_rawat,
                    'waktu_terdeteksi' => $now,
                    'waktu_ack' => null,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
            DB::connection('khanza')->table('alarm_log')->insertOrIgnore($insertData);
        }

        // 3. Ambil seluruh alarm aktif (waktu_ack IS NULL) untuk unit ini
        $selectCols = [
            'a.id',
            'a.kode_permintaan',
            'a.no_rawat',
            'a.waktu_terdeteksi',
        ];

        if ($infoColumn) {
            $selectCols[] = DB::raw('p.' . $infoColumn . ' as keterangan');
        } else {
            $selectCols[] = DB::raw("'' as keterangan");
        }

        if ($timeColumn) {
            $selectCols[] = DB::raw('p.' . $timeColumn . ' as jam');
        } else {
            $selectCols[] = DB::raw("'' as jam");
        }

        $active = DB::connection('khanza')
            ->table('alarm_log as a')
            ->leftJoin($sourceTable . ' as p', 'p.' . $keyColumn, '=', 'a.kode_permintaan')
            ->where('a.jenis', $unit)
            ->whereNull('a.waktu_ack')
            ->orderBy('a.waktu_terdeteksi', 'asc')
            ->select($selectCols)
            ->get();

        return response()->json([
            'unit' => $unit,
            'polled_at' => $now->toIso8601String(),
            'active' => $active,
        ]);
    }

    public function ack(Request $request, int $id): JsonResponse
    {
        $alarm = AlarmLog::find($id);

        if (! $alarm) {
            return response()->json(['error' => 'Alarm tidak ditemukan'], 404);
        }

        // Idempotent: hanya update jika belum di-ack
        if (is_null($alarm->waktu_ack)) {
            $alarm->update(['waktu_ack' => Carbon::now()]);
        }

        return response()->json([
            'success' => true,
            'id' => $alarm->id,
            'waktu_ack' => $alarm->waktu_ack?->toIso8601String(),
        ]);
    }
}
