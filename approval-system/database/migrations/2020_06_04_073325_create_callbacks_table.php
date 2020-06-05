<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCallbacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('callbacks', function (Blueprint $table) {
            $table->id();
            $table->string('class_path');
            $table->string('function_name');
            $table->longText('arguments')->nullable(true);
            $table->bigInteger('data_id')->unsigned()->nullable(false);
            $table->timestamps();
        });

        Schema::table('callbacks', function (Blueprint $table) {
            $table
                ->foreign('data_id')
                ->references('id')
                ->on('data')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('callbacks');
    }
}
