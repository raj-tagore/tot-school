<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailyTalliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_tallies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->date('date');
            $table->integer('visits')->default(0);
            $table->integer('calls')->default(0);
            $table->integer('leads')->default(0);
            $table->integer('registered_leads')->default(0);
            $table->integer('phone_calls')->default(0);
            $table->integer('calls_confirmed')->default(0);
            $table->integer('presentations')->default(0);
            $table->integer('demonstrations')->default(0);
            $table->integer('letters')->default(0);
            $table->integer('second_visits')->default(0);
            $table->integer('proposals')->default(0);
            $table->integer('deals_closed')->default(0);

            // Foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('daily_tallies');
    }
}

