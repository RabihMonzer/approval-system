<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRejectedNewsLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rejected_news_logs', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable(false);
            $table->text('description');
            $table->string('image', 255)->default('default.png');
            $table->bigInteger('owner_id')->unsigned()->nullable(false);
            $table->bigInteger('rejected_by')->unsigned()->nullable(false);
            $table->timestamps();
        });

        Schema::table('rejected_news_logs', function (Blueprint $table) {
            $table
                ->foreign('owner_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });

        Schema::table('rejected_news_logs', function (Blueprint $table) {
            $table
                ->foreign('rejected_by')
                ->references('id')
                ->on('users')
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
        Schema::dropIfExists('rejected_news_logs');
    }
}
