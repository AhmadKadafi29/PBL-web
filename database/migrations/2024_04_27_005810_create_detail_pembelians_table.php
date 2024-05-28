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
        Schema::create('detail_pembelian', function (Blueprint $table) {
            $table->bigIncrements('id_detail_pembelian');
            $table->unsignedBigInteger('id_pembelian');
            $table->unsignedBigInteger('id_obat');
            $table->bigInteger('harga_beli_satuan');
            $table->integer('quantity');

            $table->timestamps();
            $table->foreign('id_obat')->references('id_obat')->on('obat');
            $table->foreign('id_pembelian')->references('id_pembelian')->on('pembelian')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pembelians');
    }
};
