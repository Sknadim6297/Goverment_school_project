<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('computer_admissions', function (Blueprint $table) {
            $table->decimal('computer_fees', 10, 2)->nullable()->after('course_fee');
            $table->decimal('book_fees', 10, 2)->nullable()->after('computer_fees');
            $table->decimal('miscellaneous_fees', 10, 2)->nullable()->after('book_fees');
            $table->date('payment_date')->nullable()->after('miscellaneous_fees');
            $table->enum('payment_mode', ['cash', 'online', 'cheque'])->nullable()->after('payment_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('computer_admissions', function (Blueprint $table) {
            $table->dropColumn(['computer_fees', 'book_fees', 'miscellaneous_fees', 'payment_date', 'payment_mode']);
        });
    }
};
