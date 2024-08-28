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
        Schema::table('exams', function (Blueprint $table) {
            $table->unsignedBigInteger('course_instructor_id')->nullable()->after('semester_id');
    
            $table->foreign('course_instructor_id')->references('id')->on('course_instructors')->onDelete('set null');
        });
    }
    
    public function down()
    {
        Schema::table('exams', function (Blueprint $table) {
            $table->dropForeign(['course_instructor_id']);
            $table->dropColumn('course_instructor_id');
        });
    }
    
};
