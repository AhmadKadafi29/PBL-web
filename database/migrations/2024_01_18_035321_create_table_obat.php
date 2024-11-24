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
            Schema::create('obat', function (Blueprint $table) {
                $table->bigIncrements('id_obat');
                $table->unsignedBigInteger('kategori_obat_id');
                $table->string('nama_obat');
                $table->string('merek_obat');
                $table->text('deskripsi_obat')->nullable();
                $table->string('efek_samping')->nullable();
                $table->timestamps();

                $table->foreign('kategori_obat_id')->references('id_kategori')->on('kategori_obat');
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists('table_obat');
        }
    };
