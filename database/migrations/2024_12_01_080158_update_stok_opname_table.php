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
        Schema::table('stok_opname', function (Blueprint $table) {
            $table->dropColumn('stok_fisik');
            $table->dropColumn('stok_sistem');
            $table->dropColumn('harga_jual_satuan');
            $table->bigInteger('stok_fisik_1')->unsigned()->after('id_user');
            $table->bigInteger('stok_fisik_2')->unsigned()->after('stok_fisik_1');
            $table->bigInteger('stok_sistem_1')->unsigned()->after('stok_fisik_2');
            $table->bigInteger('stok_sistem_2')->unsigned()->after('stok_sistem_1');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stok_opname', function (Blueprint $table) {
            $table->dropColumn(['stok_fisik_1', 'stok_fisik_2']);
        });
    }
};
