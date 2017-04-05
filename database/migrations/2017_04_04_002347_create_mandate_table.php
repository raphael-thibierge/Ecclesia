<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMandateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mandates', function (Blueprint $table) {
            $table->string('uid');
            $table->primary('uid');
            $table->string('actor_uid');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->date('taking_office_date')->nullable();
            $table->string('quality')->nullable();
            $table->timestamps();

            $table->foreign('actor_uid')->references('uid')->on('actors');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mandates');
    }
}
