<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToLibraryBooksTable extends Migration
{
    public function up()
    {
        Schema::table('library_books', function (Blueprint $table) {
            $table->text('description')->nullable()->after('copies');
            $table->integer('pages')->nullable()->after('description');
        });
    }

    public function down()
    {
        Schema::table('library_books', function (Blueprint $table) {
            $table->dropColumn('description');
            $table->dropColumn('pages');
        });
    }
}
