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
        $table->unsignedBigInteger('semester_id')->nullable()->after('duration');
        
        $table->foreign('semester_id')->references('id')->on('semesters')->onDelete('set null');
    });
}

public function down()
{
    Schema::table('exams', function (Blueprint $table) {
        $table->dropForeign(['semester_id']); 
        $table->dropColumn('semester_id');
    });
}

};
