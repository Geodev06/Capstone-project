<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntrancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entrances', function (Blueprint $table) {
            $table->id();
            $table->string('payment_id');
            $table->string('user_id');
            $table->string('target_date');
            $table->integer('no_of_person')->default(1);
            $table->float('amount', 10, 2);
            $table->string('status')->nullable(true);
            $table->string('entrance_status')->nullable(true);
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
        Schema::dropIfExists('entrances');
    }
}
