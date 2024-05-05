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
        Schema::create('standings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('team_id')->unique();
            $table->integer('rank')->default(0);
            $table->integer('points')->default(0);
            $table->integer('win')->default(0);
            $table->integer('lost')->default(0);
            $table->integer('draw')->default(0);
            $table->integer('number_of_match')->default(0);
            $table->integer('home_goal')->default(0);
            $table->integer('away_goal')->default(0);
            $table->timestamps();

            $table->foreign('team_id')->references('id')->on('teams')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('standings');
    }
};
