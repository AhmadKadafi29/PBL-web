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
        Schema::create('detail_obat', function (Blueprint $table) {
            $table->bigIncrements('id_detail_obat');
            $table->unsignedBigInteger('id_obat');
            $table->unsignedBigInteger('id_pembelian');
            $table->bigInteger('stok_satuan_terkecil_1')->default(0);
            $table->bigInteger('stok_satuan_terkecil_2')->default(0);
            $table->bigInteger('harga_jual_1');
            $table->bigInteger('harga_jual_2');
            $table->date('tanggal_kadaluarsa');
            $table->timestamps();

            $table->foreign('id_obat')->references('id_obat')->on('obat')->onDelete('cascade');
            $table->foreign('id_pembelian')->references('id_pembelian')->on('pembelian')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_obats');
    }
};
