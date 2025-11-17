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
        Schema::create('roulettes', function (Blueprint $table) {
            $table->id();
            $table->integer('vocal');
            $table->integer('consonant');
            $table->integer('letter');
            $table->integer('demogorgon');
            $table->integer('demodog');
            $table->integer('vecna');
            $table->integer('eleven');
            $table->integer('option');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roulettes');
    }
};
