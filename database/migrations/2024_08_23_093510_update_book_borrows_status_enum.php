<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateBookBorrowsStatusEnum extends Migration
{
    public function up()
    {
        Schema::table('book_borrows', function (Blueprint $table) {
            $table->enum('status', ['Requested', 'Rejected', 'Borrowed', 'Returned', 'Overdue'])->default('Requested')->change();
        });
    }

    public function down()
    {
        Schema::table('book_borrows', function (Blueprint $table) {
            $table->enum('status', ['Borrowed', 'Returned', 'Overdue'])->default('Borrowed')->change();
        });
    }
}
