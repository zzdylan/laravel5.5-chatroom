<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username')->nullable()->unique()->commmet('用户名');
//            $table->string('telphone')->unique()->commmet('手机号码');
//            $table->string('email')->nullable()->unique()->commmet('邮箱');
            $table->string('password')->commmet('密码');
            $table->string('avatar')->nullable()->commmet('头像');
            $table->rememberToken();
//            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('users');
    }

}
