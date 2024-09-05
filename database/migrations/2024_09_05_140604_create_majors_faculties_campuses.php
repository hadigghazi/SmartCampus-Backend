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
        Schema::create('majors_faculties_campuses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('major_id');
            $table->unsignedBigInteger('faculty_campus_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('major_id')->references('id')->on('majors')->onDelete('cascade');
            $table->foreign('faculty_campus_id')->references('id')->on('faculties_campuses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('majors_faculties_campuses');
    }
};
