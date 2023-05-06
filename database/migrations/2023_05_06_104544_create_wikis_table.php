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
        Schema::create('wikis', function (Blueprint $table) {
            $table->id();
            $table->integer('id_produit')->unique();
            $table->integer('growing_time');
            $table->integer('space');
            $table->integer('optimal_season');
            $table->string('description');
            $table->string('type');
            $table->integer('temp_min');
            $table->integer('temp_max');
            $table->integer('hydro_min');
            $table->integer('hydro_max');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wikis');
    }
};
