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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('major_id')->constrained()->onDelete('cascade');
            $table->string('government_id', 20)->unique();
            $table->string('civil_status_number', 20);
            $table->string('passport_number', 20)->nullable()->unique();
            $table->string('visa_status', 50)->nullable();
            $table->string('native_language', 50);
            $table->string('secondary_language', 50);
            $table->foreignId('current_semester_id')->nullable()->constrained('semesters')->onDelete('set null');
            $table->text('additional_info')->nullable();
            $table->boolean('transportation');
            $table->boolean('dorm_residency');
            $table->timestamps();
            $table->softDeletes(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
