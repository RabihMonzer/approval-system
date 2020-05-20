<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialsTable extends Migration
{
    const DEFAULT_MATERIAL_STATUS = 'Pending Approval';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->string('title')->nullable(false);
            $table->string('content')->nullable(false);
            $table->bigInteger('type_id')->unsigned();
            $table->string('status')->nullable(false)->default(self::DEFAULT_MATERIAL_STATUS);
            $table->timestamps();
        });

        Schema::table('materials', function (Blueprint $table) {
            $table
                ->foreign('user_id')
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
        Schema::dropIfExists('materials');
    }
}
