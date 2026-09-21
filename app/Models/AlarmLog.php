<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class AlarmLog extends Model
{
    protected $connection = 'khanza';

    protected $table = 'alarm_log';

    protected $fillable = [
        'jenis',
        'kode_permintaan',
        'no_rawat',
        'waktu_terdeteksi',
        'waktu_ack',
    ];

    protected $casts = [
        'waktu_terdeteksi' => 'datetime',
        'waktu_ack' => 'datetime',
    ];

    /**
     * Hanya alarm yang belum di-acknowledge (waktu_ack masih NULL).
     */
    public function scopeAktif(Builder $query): Builder
    {
        return $query->whereNull('waktu_ack');
    }

    /**
     * Filter berdasarkan unit: 'lab' | 'radiologi' | 'farmasi'.
     */
    public function scopeJenis(Builder $query, string $jenis): Builder
    {
        return $query->where('jenis', $jenis);
    }
}
