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
        Schema::create('deans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('faculty_id')
                  ->constrained('faculties')
                  ->onDelete('cascade');
            $table->foreignId('campus_id')
                  ->constrained('campuses')
                  ->onDelete('cascade');
            $table->string('role_description');
            $table->timestamps();
            $table->softDeletes(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deans');
    }
};
