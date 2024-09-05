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
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100); 
            $table->text('content');
            $table->date('published_date');
            $table->foreignId('author_id')->constrained('users')->onDelete('cascade');
            $table->enum('visibility', ['General', 'Admins', 'Instructors', 'Students']);
            $table->enum('category', ['General', 'Urgent', 'Event']); 
            $table->timestamps(); 
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};
