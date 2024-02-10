<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('total_tallies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
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
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('total_tallies');
    }
};
