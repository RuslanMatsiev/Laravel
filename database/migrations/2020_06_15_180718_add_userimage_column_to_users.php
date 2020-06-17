<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserimageColumnToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    // Добавляем столбец аватара пользователя в таблицу 
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('userimage')->nullable();
        });    
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */

    // Удаляем столбец аватара пользователя в таблицу  
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('userimage');
        });   
    }
}
