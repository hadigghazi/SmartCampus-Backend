<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('course_evaluations', function (Blueprint $table) {
            $table->id();
            $table->integer('teaching_number');
            $table->string('teaching');
            $table->integer('coursecontent_number');
            $table->string('coursecontent');
            $table->integer('examination_number');
            $table->string('examination');
            $table->integer('labwork_number');
            $table->string('labwork');
            $table->integer('library_facilities_number');
            $table->string('library_facilities');
            $table->integer('extracurricular_number');
            $table->string('extracurricular');
            $table->foreignId('course_instructor_id')->constrained('course_instructors')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_evaluations');
    }
};
