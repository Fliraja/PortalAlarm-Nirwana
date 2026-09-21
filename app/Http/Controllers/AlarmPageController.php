<?php

namespace App\Http\Controllers;

use App\Models\AlarmLog;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AlarmPageController extends Controller
{
    public function show(Request $request, string $unit): View|RedirectResponse
    {
        $units = config('alarm.units', []);

        if (! array_key_exists($unit, $units)) {
            abort(404, 'Unit tidak ditemukan');
        }

        $unitConfig = $units[$unit];
        $pollInterval = config('alarm.poll_interval_ms', 7000);

        $today = Carbon::today()->toDateString();

        $activeAlarms = AlarmLog::where('jenis', $unit)
            ->whereNull('waktu_ack')
            ->orderBy('waktu_terdeteksi', 'asc')
            ->get();

        $todayLogs = AlarmLog::where('jenis', $unit)
            ->whereDate('waktu_terdeteksi', $today)
            ->orderBy('waktu_terdeteksi', 'desc')
            ->take(50)
            ->get();

        $stats = [
            'active' => $activeAlarms->count(),
            'completed' => AlarmLog::where('jenis', $unit)
                ->whereDate('waktu_terdeteksi', $today)
                ->whereNotNull('waktu_ack')
                ->count(),
            'total_today' => AlarmLog::where('jenis', $unit)
                ->whereDate('waktu_terdeteksi', $today)
                ->count(),
        ];

        return view('alarm.page', [
            'unit' => $unit,
            'unitConfig' => $unitConfig,
            'pollInterval' => $pollInterval,
            'activeAlarms' => $activeAlarms,
            'todayLogs' => $todayLogs,
            'stats' => $stats,
        ]);
    }
}
