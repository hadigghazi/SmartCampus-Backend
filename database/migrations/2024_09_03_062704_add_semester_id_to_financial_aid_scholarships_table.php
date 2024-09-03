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
    Schema::table('financial_aid_scholarships', function (Blueprint $table) {
        $table->unsignedBigInteger('semester_id')->after('student_id');

        $table->foreign('semester_id')->references('id')->on('semesters')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('financial_aid_scholarships', function (Blueprint $table) {
            //
        });
    }
};
