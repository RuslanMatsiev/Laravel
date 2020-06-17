<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDateToPosts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   
    // Добавляем колонку даты в таблицу постов 
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->date('date')->nullable();
        }); 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */

    // Удаляем колонку даты из таблицы постов 
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('date');
        }); 
    }
}
