<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material_types', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable(false)->unique();
            $table->timestamps();
        });

        Schema::table('materials', function (Blueprint $table) {
            $table
                ->foreign('type_id')
                ->references('id')
                ->on('material_types');
        });


        Schema::table('rejected_material_logs', function (Blueprint $table) {
            $table
                ->foreign('type_id')
                ->references('id')
                ->on('material_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('material_types');
    }
}
