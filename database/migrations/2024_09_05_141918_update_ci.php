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
        Schema::table('registrations', function (Blueprint $table) {
            $table->dropColumn('course_id');
            $table->dropColumn('instructor_id');
            
            $table->unsignedBigInteger('course_instructor_id')->after('id');
            $table->foreign('course_instructor_id')
                  ->references('id')
                  ->on('course_instructors')
                  ->onDelete('cascade');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
