<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDescriptionToPosts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    // Добавляем колонку краткого описания в таблицу постов   
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->text('description')->nullable();
        }); 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */

    // Удаляем колонку краткого описания из таблицы постов 
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('description');
        }); 
    }
}
