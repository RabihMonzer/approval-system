<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Dictionaries\DataStatusDictionary;

class CreateDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data', function (Blueprint $table) {
            $table->id();
            $table->string('status')->nullable(false)->default(DataStatusDictionary::PENDING_APPROVAL);
            $table->longText('data')->nullable(false);
            $table->string('table_name');
            $table->string('transaction_type')->nullable(false);
            $table->bigInteger('created_by')->unsigned()->nullable(false);
            $table->bigInteger('updated_by')->unsigned()->nullable(true);
            $table->timestamps();
        });

        Schema::table('data', function (Blueprint $table) {
            $table
                ->foreign('created_by')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });

        Schema::table('data', function (Blueprint $table) {
            $table
                ->foreign('updated_by')
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
        Schema::dropIfExists('data');
    }
}
