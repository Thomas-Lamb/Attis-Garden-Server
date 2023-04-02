<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBacsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bacs', function (Blueprint $table) {
            $table->id();
            $table->integer('id_proprio');
            $table->string('name', 20);
            $table->integer('id_comp_1')->unique();
            $table->integer('id_comp_2')->unique();
            $table->integer('id_comp_3')->unique();
            $table->integer('id_comp_4')->unique();
            $table->string('bac_token', 20)->unique();
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
        Schema::dropIfExists('bacs');
    }
}
