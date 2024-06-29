<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('penjualan_resep', function (Blueprint $table) {
            $table->bigIncrements('id_penjualan_resep');
            $table->string('nama_pasien');
            $table->string('alamat_pasien');
            $table->enum('jenis_kelamin',['L', 'P']);
            $table->string('nama_dokter');
            $table->bigInteger('nomor_sip');
            $table->date('tanggal_penjualan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualan_resep');
    }
};
