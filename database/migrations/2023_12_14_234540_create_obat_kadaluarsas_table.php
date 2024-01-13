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
        Schema::create('obat_kadaluarsa', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_obat')->unsigned();
            $table->date('tanggal_kadaluarsa');
            $table->timestamps();

            $table->foreign('id_obat')->references('id')->on('obat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('obat_kadaluarsa');
    }
};
