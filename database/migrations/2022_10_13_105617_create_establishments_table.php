<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstablishmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('establishments', function (Blueprint $table) {
            $table->id();
            $table->string('establishment_name');
            $table->string('establishment_address');
            $table->string('schedule');
            $table->string('contact');
            $table->string('email');
            $table->string('open');
            $table->string('close');
            $table->string('lat')->nullable(true);
            $table->string('long')->nullable(true);
            $table->boolean('available')->default(true);
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
        Schema::dropIfExists('establishments');
    }
}
