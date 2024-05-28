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
            $table->bigInteger('id_supplier')->unsigned();
            $table->bigInteger('no_faktur');
            $table->double('total_harga');
            $table->date('tanggal_pembelian');
            $table->string('status_pembayaran')->default('lunas');
            $table->timestamps();

            $table->foreign('id_supplier')->references('id_supplier')->on('supplier')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_pembelian');
    }
};
