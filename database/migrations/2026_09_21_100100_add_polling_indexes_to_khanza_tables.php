<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * PERHATIAN: migration ini mengubah (ALTER) tabel milik Khanza/RME-Nirwana
     * yang aktif dipakai produksi (permintaan_lab, permintaan_radiologi,
     * resep_obat). Perubahannya cuma nambah index (additive, tidak mengubah
     * data atau kolom apa pun), tapi tetap jalankan ini terpisah dari
     * migration lain dan pastikan ada backup/jam sepi sebelum migrate di DB
     * production.
     */
    protected $connection = 'khanza';

    public function up(): void
    {
        Schema::table('permintaan_lab', function (Blueprint $table) {
            $table->index(['tgl_permintaan', 'noorder'], 'permintaan_lab_tgl_noorder_index');
        });

        Schema::table('permintaan_radiologi', function (Blueprint $table) {
            $table->index(['tgl_permintaan', 'noorder'], 'permintaan_radiologi_tgl_noorder_index');
        });

        Schema::table('resep_obat', function (Blueprint $table) {
            $table->index(['tgl_peresepan', 'no_resep'], 'resep_obat_tgl_peresepan_no_resep_index');
        });
    }

    public function down(): void
    {
        Schema::table('permintaan_lab', function (Blueprint $table) {
            $table->dropIndex('permintaan_lab_tgl_noorder_index');
        });

        Schema::table('permintaan_radiologi', function (Blueprint $table) {
            $table->dropIndex('permintaan_radiologi_tgl_noorder_index');
        });

        Schema::table('resep_obat', function (Blueprint $table) {
            $table->dropIndex('resep_obat_tgl_peresepan_no_resep_index');
        });
    }
};
