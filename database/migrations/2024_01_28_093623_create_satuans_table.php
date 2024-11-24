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
        Schema::create('satuans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_obat')->references('id_obat')->on('obat')->onDelete('cascade');
            $table->string('satuan_terbesar');
            $table->string('satuan_terkecil_1');
            $table->integer('jumlah_satuan_terkecil_1');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('satuans');
    }
};
