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
        Schema::create('book_borrows', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')
                  ->constrained('students')
                  ->onDelete('cascade');
            $table->foreignId('book_id')
                  ->constrained('library_books')
                  ->onDelete('cascade');
            $table->date('due_date');
            $table->date('return_date')->nullable();
            $table->enum('status', ['Requested', 'Rejected', 'Borrowed', 'Returned', 'Overdue']);
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes(); 
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_borrows');
    }
};
