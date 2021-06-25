<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BuatTabelUnduhanFile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('unduhan_file')) {
            Schema::create('unduhan_file', function (Blueprint $table) {
                $table->increments('id');

                $table->uuid('uuid');
                $table->string('judul');
                $table->string('slug')->unique();
                $table->string('file');
                
                $table->integer('download')->default(0);

                $table->integer('id_kategori')->nullable();
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
        Schema::dropIfExists('unduhan_file');
    }
}
