<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('government_id', 20);
            $table->string('civil_status_number', 20);
            $table->string('passport_number', 20);
            $table->string('visa_status', 50);
            $table->string('native_language', 50);
            $table->string('secondary_language', 50);
            $table->foreignId('current_semester_id')->constrained('semesters')->onDelete('cascade');
            $table->text('additional_info')->nullable();
            $table->boolean('transportation')->default(false);
            $table->boolean('dorm_residency')->default(false);
            $table->foreignId('emergency_contact_id')->constrained('contacts')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes(); // For soft deletes
        });
    }

    public function down()
    {
        Schema::dropIfExists('students');
    }
}
