<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreategradesTable extends Migration
{
    public function up()
    {
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('registration_id');
            $table->decimal('grade', 5, 2);
            $table->char('letter_grade', 2);
            $table->decimal('gpa', 3, 2);
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('registration_id')->references('id')->on('registrations');
        });
    }

    public function down()
    {
        Schema::dropIfExists('grades');
    }
}
