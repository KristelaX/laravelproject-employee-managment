<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->increments('dep_id');
            $table->string('dep_name');
            $table->string('location');
            //$table->integer('parent_id')->foreign('parent_id')->reference('dep_id')->on('departments');
            $table->integer('parent_id');
            $table->integer('manager_id')->unsigned()->default(0)->foreign('manager_id')->reference('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('departments');
    }
}
