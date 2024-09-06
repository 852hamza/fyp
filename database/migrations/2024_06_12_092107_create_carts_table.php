<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartsTable extends Migration
{
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->increments('id'); // Primary key
            $table->unsignedInteger('user_id'); // Foreign key for user
            $table->unsignedInteger('property_id'); // Foreign key for property
            $table->integer('quantity')->default(1);
            $table->timestamps();

            // Define foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('carts');
    }
}