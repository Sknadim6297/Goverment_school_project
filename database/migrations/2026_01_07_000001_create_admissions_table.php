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
        Schema::create('admissions', function (Blueprint $table) {
            $table->id();
            $table->string('admission_no')->unique();
            $table->date('admission_date');
            $table->string('name');
            $table->string('class');
            $table->string('section')->nullable();
            $table->string('rollno')->nullable();
            $table->string('stream')->nullable();
            $table->string('guardian_name');
            $table->string('mobile_number', 10);
            $table->decimal('total_fees', 10, 2)->default(0);
            $table->decimal('paid_amount', 10, 2)->default(0);
            $table->enum('payment_status', ['pending', 'partial', 'paid'])->default('pending');
            $table->text('address')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('photo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admissions');
    }
};
