<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddImageToPosts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    // Добавляем колонку превью поста в таблицу постов  
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->string('image')->nullable();
        }); 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */

    // Удаляем колонку превью поста из таблицы постов  
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('image');
        });
    }
}
