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
        Schema::create('pembelian', function (Blueprint $table) {
            $table->bigIncrements('id_pembelian');
            $table->bigInteger('id_obat')->unsigned();
            $table->bigInteger('id_supplier')->unsigned();
            $table->bigInteger('nofaktur');
            $table->double('harga_satuan');
            $table->integer('quantity');
            $table->double('total_harga');
            $table->date('tanggal_pembelian');
            $table->string('status_pembayaran')->default('lunas');
            $table->timestamps();

            $table->foreign('id_obat')->references('id')->on('obat')->cascade();
            $table->foreign('id_supplier')->references('id')->on('supplier')->cascade();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembelian');
    }
};
