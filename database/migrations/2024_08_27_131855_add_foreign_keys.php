<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('assignments', function (Blueprint $table) {
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
        });

        Schema::table('submissions', function (Blueprint $table) {
            $table->foreign('assignment_id')->references('id')->on('assignments')->onDelete('cascade');
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
        });

        Schema::table('fees', function (Blueprint $table) {
            $table->foreign('faculty_id')->references('id')->on('faculties')->onDelete('cascade');
        });

        Schema::table('financial_aid_scholarships', function (Blueprint $table) {
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('exams', function (Blueprint $table) {
            $table->dropForeign(['course_id']);
            $table->dropForeign(['instructor_id']);
        });

        Schema::table('assignments', function (Blueprint $table) {
            $table->dropForeign(['course_id']);
        });

        Schema::table('submissions', function (Blueprint $table) {
            $table->dropForeign(['assignment_id']);
            $table->dropForeign(['student_id']);
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign(['student_id']);
        });

        Schema::table('fees', function (Blueprint $table) {
            $table->dropForeign(['faculty_id']);
        });

        Schema::table('financial_aid_scholarships', function (Blueprint $table) {
            $table->dropForeign(['student_id']);
        });
    }
}
