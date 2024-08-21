<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMajorFacultyCampusesTable extends Migration
{
    public function up()
    {
        Schema::create('majors_faculties_campuses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('major_id')->constrained('majors')->onDelete('cascade');
            $table->foreignId('faculty_campus_id')->constrained('faculties_campuses')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('majors_faculties_campuses');
    }
}
