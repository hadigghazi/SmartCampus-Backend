<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDormRoomsTable extends Migration
{
    public function up()
    {
        Schema::create('dorm_rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dorm_id')->constrained()->onDelete('cascade');
            $table->string('room_number');
            $table->integer('capacity');
            $table->integer('available_beds');
            $table->integer('floor');
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dorm_rooms');
    }
}
