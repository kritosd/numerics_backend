<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLuckyforlivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('luckyforlife', function (Blueprint $table) {
            $table->bigIncrements('draw_id');
            $table->date('draw_date');
            $table->time('draw_time')->nullable();
            $table->string('winning_column', 255);
            $table->integer('balander')->nullable();
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
        Schema::dropIfExists('luckyforlife');
    }
}
