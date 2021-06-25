<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BuatTabelPluginLayanan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('plugin_layanan')) {
            Schema::create('plugin_layanan', function (Blueprint $table) {
                $table->increments('id');

                $table->uuid('uuid');
                $table->string('nama')->nullable();
                $table->string('slug')->nullable();
                $table->string('pd')->nullable();
                $table->integer('bidang')->nullable();
                $table->string('alamat')->nullable();
                
                $table->string('lampiran')->nullable();
                
                $table->string('narahubung_nama')->nullable();
                $table->string('narahubung_jabatan')->nullable();
                $table->string('narahubung_telepon')->nullable();
                $table->text('keterangan')->nullable();

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
        Schema::dropIfExists('plugin_layanan');
    }
}
