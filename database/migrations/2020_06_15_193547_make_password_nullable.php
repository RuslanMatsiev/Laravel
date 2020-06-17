<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakePasswordNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    // Изменение поля пароля пользователя 
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('password')->nullable()->change();
        });  
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */

    // Отменить изменения поля пароля пользователя 
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('password')->change();
        });   
    }
}
