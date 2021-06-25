<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BuatTabelPluginPengadaan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('plugin_pengadaan')) {
            Schema::create('plugin_pengadaan', function (Blueprint $table) {
                $table->increments('id');

                $table->uuid('uuid');
                $table->string('no_paket')->nullable();
                
                $table->string('tahun')->nullable();
                $table->string('nama_kegiatan')->nullable();
                $table->string('nama_paket')->nullable();

                $table->bigInteger('pagu')->default(0);
                $table->integer('jenis_belanja')->nullable();
                $table->string('volume')->nullable();
                $table->string('lokasi')->nullable();
                $table->text('deskripsi')->nullable();

                $table->integer('sumber_dana')->nullable();
                $table->bigInteger('sumber_dana_pagu')->nullable();
                $table->string('sumber_dana_mak')->nullable();

                $table->integer('penyedia')->nullable();

                $table->string('penyedia_awal')->nullable();
                $table->string('penyedia_akhir')->nullable();
                $table->string('pelaksanaan_awal')->nullable();
                $table->string('pelaksanaan_akhir')->nullable();

                $table->integer('id_operator')->nullable();

                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plugin_pengadaan');
    }
}
