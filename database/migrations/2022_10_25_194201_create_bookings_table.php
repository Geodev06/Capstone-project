<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('payment_id');
            $table->string('checker_name');
            $table->string('address');
            $table->string('email');
            $table->string('mobile');
            $table->string('target_date');
            $table->string('check_out_date');
            $table->string('plan');
            $table->integer('hour');
            $table->string('user_id');
            $table->string('room_no');
            $table->string('validity');
            $table->string('status');
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
        Schema::dropIfExists('bookings');
    }
}
