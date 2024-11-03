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
        Schema::create('detail_satuans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_obat');
            $table->unsignedBigInteger('id_satuan');
            $table->integer('satuan_konversi');
       

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detailsatuans');
    }
};
