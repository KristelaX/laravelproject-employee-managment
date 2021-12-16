<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('adresa')->nullable();
            $table->boolean('is_admin')->default(0);
            $table->string('picture')->nullable();
            $table->integer('dep_fk')->unsigned()->default(1)->foreign('dep_fk')->reference('dep_id')->on('departments')->onDelete('cascade')->onUpdate('cascade');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * --
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
