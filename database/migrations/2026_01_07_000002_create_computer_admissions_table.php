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
        Schema::create('computer_admissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admission_id')->constrained('admissions')->onDelete('cascade');
            $table->date('enrollment_date');
            $table->string('course_name');
            $table->decimal('course_fee', 10, 2);
            $table->decimal('paid_amount', 10, 2)->default(0);
            $table->enum('payment_status', ['pending', 'partial', 'paid'])->default('pending');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('computer_admissions');
    }
};
