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
        Schema::create('stok_opname', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_obat')->unsigned();
            $table->bigInteger('id_user')->unsigned();
            $table->bigInteger('stok_fisik');
            $table->string('status')->default('belum kadaluarsa');
            $table->date('tanggal_kadaluarsa');
            $table->timestamps();

            $table->foreign('id_obat')->references('id')->on('obat');
            $table->foreign('id_user')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stok_opnames');
    }
};
