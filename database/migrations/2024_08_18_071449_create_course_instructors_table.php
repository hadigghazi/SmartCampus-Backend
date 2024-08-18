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
    Schema::create('course_instructors', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('course_id');
        $table->unsignedBigInteger('instructor_id');
        $table->unsignedBigInteger('semester_id');
        $table->integer('capacity');
        $table->unsignedBigInteger('campus_id');
        $table->unsignedBigInteger('room_id');
        $table->string('schedule', 100);
        $table->timestamps();
        $table->softDeletes();

        $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
        $table->foreign('instructor_id')->references('id')->on('instructors')->onDelete('cascade');
        $table->foreign('semester_id')->references('id')->on('semesters')->onDelete('cascade');
        $table->foreign('campus_id')->references('id')->on('campuses')->onDelete('cascade');
        $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_instructors');
    }
};
