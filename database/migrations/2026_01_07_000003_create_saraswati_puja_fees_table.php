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
        Schema::create('saraswati_puja_fees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admission_id')->constrained('admissions')->onDelete('cascade');
            $table->year('year');
            $table->decimal('fee_amount', 10, 2);
            $table->date('payment_date');
            $table->string('receipt_no')->unique();
            $table->enum('payment_mode', ['cash', 'online', 'cheque'])->default('cash');
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saraswati_puja_fees');
    }
};
