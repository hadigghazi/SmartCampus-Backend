<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDormsTable extends Migration
{
    public function up()
    {
        Schema::create('dorms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->integer('capacity');
            $table->integer('available_rooms');
            $table->foreignId('campus_id')->constrained()->onDelete('cascade');
            $table->text('address');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dorms');
    }
}
