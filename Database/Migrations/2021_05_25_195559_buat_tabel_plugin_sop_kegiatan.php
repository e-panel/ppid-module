<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BuatTabelPluginSopKegiatan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('plugin_sop_kegiatan')) {
            Schema::create('plugin_sop_kegiatan', function (Blueprint $table) {
                $table->increments('id');

                $table->uuid('uuid');
                $table->string('judul')->nullable();
                $table->string('slug')->nullable();
                
                $table->integer('id_bidang')->nullable();
                $table->string('file')->nullable();
                
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
        Schema::dropIfExists('plugin_sop_kegiatan');
    }
}
