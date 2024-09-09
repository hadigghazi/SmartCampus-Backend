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
    Schema::create('salary_payments', function (Blueprint $table) {
        $table->id();
        $table->decimal('amount', 10, 2);
        $table->date('payment_date');
        $table->unsignedBigInteger('recipient_id');
        $table->enum('recipient_type', ['Instructor', 'Admin']);
        $table->timestamps();
        $table->softDeletes();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
