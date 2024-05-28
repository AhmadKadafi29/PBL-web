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
        Schema::create('detail_penjualan', function (Blueprint $table) {
            $table->bigIncrements('id_detail_penjualan');
            $table->unsignedBigInteger('id_penjualan');
            $table->unsignedBigInteger('id_obat');
            $table->bigInteger('harga_jual_satuan');
            $table->bigInteger('harga_beli_satuan');
            $table->timestamps();

            $table->foreign('id_penjualan')->references('id_penjualan')->on('penjualan')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_obat')->references('id_obat')->on('obat')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_penjualans');
    }
};
