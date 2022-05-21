<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceSupportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_supports', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('parkings_id');
            $table->foreign('parkings_id')->references('id')->on('parkings');
            $table->unsignedBigInteger('users_id');
            $table->foreign('users_id')->references('id')->on('users');
            $table->string('title');
            $table->text('description')->nullable(true);
            $table->tinyInteger('status')->default(1);
            $table->text('answer')->nullable(true);

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
        Schema::dropIfExists('service_supports');
    }
}
