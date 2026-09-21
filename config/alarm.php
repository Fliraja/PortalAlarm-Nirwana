<?php

return [
    'units' => [
        'lab' => [
            'label' => 'Lab',
            'source_table' => 'permintaan_lab',
            'key_column' => 'noorder',
            'date_column' => 'tgl_permintaan',
            'time_column' => 'jam_permintaan',
            'info_column' => 'informasi_tambahan',
        ],
        'radiologi' => [
            'label' => 'Radiologi',
            'source_table' => 'permintaan_radiologi',
            'key_column' => 'noorder',
            'date_column' => 'tgl_permintaan',
            'time_column' => 'jam_permintaan',
            'info_column' => 'informasi_tambahan',
        ],
        'apotek' => [
            'label' => 'Apotek',
            'source_table' => 'resep_obat',
            'key_column' => 'no_resep',
            'date_column' => 'tgl_peresepan',
            'time_column' => 'jam_peresepan',
            'info_column' => 'status',
        ],
    ],
    'poll_interval_ms' => env('ALARM_POLL_INTERVAL_MS', 7000),
];
