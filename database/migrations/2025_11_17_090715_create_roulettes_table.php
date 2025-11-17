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
            $table->vocal();
            $table->consonant();
            $table->letter();
            $table->demogorgon();
            $table->demodog();
            $table->vecna();
            $table->eleven();
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
