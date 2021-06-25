<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BuatTabelUnduhanKategori extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('unduhan_kategori')) {
            Schema::create('unduhan_kategori', function (Blueprint $table) {
                $table->increments('id');

                $table->uuid('uuid');
                $table->string('label');
                $table->string('slug')->unique();

                $table->integer('hit')->default(0);
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
        Schema::dropIfExists('unduhan_kategori');
    }
}
