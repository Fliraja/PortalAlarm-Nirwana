<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Mapping unit -> sumber data
    |--------------------------------------------------------------------------
    |
    | Tambah entri baru di sini kalau ada unit tambahan ke depan (IGD, Ranap),
    | tanpa perlu nulis controller baru dari nol.
    |
    */

    'units' => [

        'lab' => [
            'label' => 'Lab',
            'source_table' => 'permintaan_lab',
            'key_column' => 'noorder',
            'date_column' => 'tgl_permintaan',
        ],

        'radiologi' => [
            'label' => 'Radiologi',
            'source_table' => 'permintaan_radiologi',
            'key_column' => 'noorder',
            'date_column' => 'tgl_permintaan',
        ],

        'apotek' => [
            'label' => 'Apotek',
            'source_table' => 'resep_obat',
            'key_column' => 'no_resep',
            'date_column' => 'tgl_peresepan',
        ],

    ],

    'poll_interval_ms' => env('ALARM_POLL_INTERVAL_MS', 7000),

];
