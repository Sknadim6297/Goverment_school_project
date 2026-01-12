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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            
            // A. Basic Information
            $table->string('student_profile')->nullable();
            $table->string('name');
            $table->date('dob');
            $table->string('birth_regn_no', 100)->nullable();
            $table->string('gender', 20)->nullable();
            $table->string('social_category', 20)->nullable();
            $table->string('religion', 50)->nullable();
            $table->string('mother_tongue', 50)->default('Bengali');
            $table->string('nationality', 50)->default('Indian');
            $table->string('aadhar_no', 20)->nullable();
            $table->string('blood_group', 10)->nullable();
            $table->string('health_id', 50)->nullable();
            $table->string('identyfication_mark', 100)->nullable();
            
            // B. Educational Information
            $table->string('academic_year', 20)->nullable();
            $table->string('admission_no', 50)->nullable();
            $table->date('admission_date')->nullable();
            $table->string('present_class', 20)->nullable();
            $table->string('present_section', 10)->nullable();
            $table->string('present_roll_no', 20)->nullable();
            $table->string('present_streams', 50)->nullable();
            $table->string('previous_class', 20)->nullable();
            $table->string('previous_section', 10)->nullable();
            $table->string('previous_roll_no', 20)->nullable();
            $table->string('previous_streams', 50)->nullable();
            $table->string('medium', 50)->nullable();
            $table->string('status_of_previous_year', 100)->nullable();
            $table->string('child_attend_school', 50)->nullable();
            
            // C. Contact Information
            $table->text('address')->nullable();
            $table->string('locality', 100)->nullable();
            $table->string('district', 100)->nullable();
            $table->string('block_municipaity', 100)->nullable();
            $table->string('panchayat', 100)->nullable();
            $table->string('post_office', 100)->nullable();
            $table->string('police_station', 100)->nullable();
            $table->string('pincode', 10)->nullable();
            $table->string('contact_no', 15)->nullable();
            $table->string('email_id', 100)->nullable();
            
            // D. Guardian's Details
            $table->string('father_name', 100)->nullable();
            $table->string('mother_name', 100)->nullable();
            $table->string('gurdain_name', 100)->nullable();
            $table->string('relation', 50)->nullable();
            $table->string('family_income', 50)->nullable();
            $table->string('gurdain_qualification', 100)->nullable();
            
            // E. Guardian's Contact Information
            $table->text('gurd_address')->nullable();
            $table->string('gurd_locality', 100)->nullable();
            $table->string('gurd_district', 100)->nullable();
            $table->string('gurd_block_municipaity', 100)->nullable();
            $table->string('gurd_panchayat', 100)->nullable();
            $table->string('gurd_post_office', 100)->nullable();
            $table->string('gurd_police_station', 100)->nullable();
            $table->string('gurd_pincode', 10)->nullable();
            $table->string('gurd_contact_no', 15)->nullable();
            $table->string('gurd_email_id', 100)->nullable();
            
            // F. Other Information
            $table->string('bpl_status', 10)->nullable();
            $table->string('bpl_no', 50)->nullable();
            $table->string('special_need', 10)->nullable();
            $table->string('disability', 100)->nullable();
            
            // G. Facilities
            $table->string('disadvantage_group', 10)->nullable();
            $table->string('free_education_rte', 10)->nullable();
            $table->string('child_is_homeless', 100)->nullable();
            $table->string('uniform_received', 50)->nullable();
            $table->string('free_books', 100)->nullable();
            $table->string('transport_facility', 10)->nullable();
            $table->string('escort_facility', 10)->nullable();
            $table->string('hostel_facility', 10)->nullable();
            $table->string('hostel_type', 100)->nullable();
            $table->string('hostel_schemes', 100)->nullable();
            $table->string('special_training_facility', 10)->nullable();
            $table->text('remarks')->nullable();
            $table->string('cwsn_facility_receive', 100)->nullable();
            $table->string('free_bicycle', 10)->nullable();
            $table->string('free_shoe', 10)->nullable();
            $table->string('exercise_book', 10)->nullable();
            
            // H. Bank Details
            $table->string('bank_name', 100)->nullable();
            $table->string('branch_code', 50)->nullable();
            $table->string('ifsc', 20)->nullable();
            $table->string('account_no', 50)->nullable();
            
            // I. Upload Documents
            $table->string('aadhar_picture')->nullable();
            $table->string('birth_certificate')->nullable();
            $table->string('tc_certificate')->nullable();
            $table->string('social_certificate')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
