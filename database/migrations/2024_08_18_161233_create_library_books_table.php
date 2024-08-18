<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLibraryBookTable extends Migration
{
    public function up()
    {
        Schema::create('library_books', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100);
            $table->string('author', 100);
            $table->string('isbn', 20);
            $table->integer('copies');
            $table->integer('publication_year');
            $table->foreignId('campus_id')->constrained('campuses')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('library_books');
    }
}
