<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompartimentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compartiments', function (Blueprint $table) {
            $table->id();
            $table->integer('id_bac')->nullable();
            $table->integer('id_plante');
            $table->integer('id_proprio');
            $table->date('date_plantation')->nullable();
            $table->integer('cap_temp')->nullable();
            $table->integer('cap_hydro')->nullable();
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
        Schema::dropIfExists('compartiments');
    }
}
