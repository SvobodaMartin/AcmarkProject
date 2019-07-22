<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAcmarkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acmark', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('ico')->nullable()->unique();
            $table->string('name')->nullable();
            $table->text('activityDsc')->nullable();
            $table->text('activityCode')->nullable();
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
        Schema::dropIfExists('acmark');
    }
}
