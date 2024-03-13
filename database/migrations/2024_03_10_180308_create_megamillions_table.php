<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMegamillionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('megamillions', function (Blueprint $table) {
            $table->bigIncrements('draw_id');
            $table->date('draw_date');
            $table->time('draw_time')->nullable();
            $table->string('winning_column', 255);
            $table->integer('balander')->nullable();
            $table->integer('multiplier')->nullable();
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
        Schema::dropIfExists('megamillions');
    }
}
