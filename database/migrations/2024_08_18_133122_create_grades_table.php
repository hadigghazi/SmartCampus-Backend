<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGradesTable extends Migration
{
    public function up()
    {
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->('80');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('id')->references('id')->on('registrations');
        });
    }

    public function down()
    {
        Schema::dropIfExists('grades');
    }
}
