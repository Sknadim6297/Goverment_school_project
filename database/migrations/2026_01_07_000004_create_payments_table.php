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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admission_id')->constrained('admissions')->onDelete('cascade');
            $table->string('receipt_no')->unique();
            $table->decimal('amount', 10, 2);
            $table->date('payment_date');
            $table->enum('payment_mode', ['cash', 'online', 'cheque'])->default('cash');
            $table->string('transaction_id')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
