<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberPortalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_portals', function (Blueprint $table) {
            $table->id();
            $table->string('user')->unique();
            $table->integer('winning_number_1')->unique()->nullable();
            $table->integer('winning_number_2')->unique()->nullable();
            $table->integer('winning_number_3')->unique()->nullable();
            $table->integer('winning_number_4')->unique()->nullable();
            $table->integer('winning_number_5')->unique()->nullable();
            $table->string('prize_type')->nullable();            
            $table->boolean('won_prize')->default(false);
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
        Schema::dropIfExists('member_portals');
    }
}
