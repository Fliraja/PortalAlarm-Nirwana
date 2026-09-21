<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel ini sengaja dijalankan di koneksi 'khanza' (bukan default),
     * supaya alarm_log landing di database fisik yang sama dengan tabel
     * sumber (permintaan_lab, permintaan_radiologi, resep_obat) — anti-join
     * polling cuma bisa jadi 1 query SQL kalau satu database.
     */
    protected $connection = 'khanza';

    public function up(): void
    {
        Schema::create('alarm_log', function (Blueprint $table) {
            $table->id();
            $table->string('jenis', 20); // 'lab' | 'radiologi' | 'farmasi'
            $table->string('kode_permintaan', 50); // noorder (lab/radiologi) atau no_resep (apotek)
            $table->string('no_rawat', 17);
            $table->dateTime('waktu_terdeteksi');
            $table->dateTime('waktu_ack')->nullable(); // NULL = alarm masih aktif
            $table->timestamps();

            $table->index('kode_permintaan');
            $table->index('waktu_ack');
            $table->index(['jenis', 'waktu_ack']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alarm_log');
    }
};
