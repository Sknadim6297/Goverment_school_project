<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        // A. Basic Information
        'student_profile', 'name', 'dob', 'birth_regn_no', 'gender', 'social_category',
        'religion', 'mother_tongue', 'nationality', 'aadhar_no', 'blood_group',
        'health_id', 'identyfication_mark',
        
        // B. Educational Information
        'academic_year', 'admission_no', 'admission_date', 'present_class',
        'present_section', 'present_roll_no', 'present_streams', 'previous_class',
        'previous_section', 'previous_roll_no', 'previous_streams', 'medium',
        'status_of_previous_year', 'child_attend_school',
        
        // C. Contact Information
        'address', 'locality', 'district', 'block_municipaity', 'panchayat',
        'post_office', 'police_station', 'pincode', 'contact_no', 'email_id',
        
        // D. Guardian's Details
        'father_name', 'mother_name', 'gurdain_name', 'relation',
        'family_income', 'gurdain_qualification',
        
        // E. Guardian's Contact Information
        'gurd_address', 'gurd_locality', 'gurd_district', 'gurd_block_municipaity',
        'gurd_panchayat', 'gurd_post_office', 'gurd_police_station', 'gurd_pincode',
        'gurd_contact_no', 'gurd_email_id',
        
        // F. Other Information
        'bpl_status', 'bpl_no', 'special_need', 'disability',
        
        // G. Facilities
        'disadvantage_group', 'free_education_rte', 'child_is_homeless',
        'uniform_received', 'free_books', 'transport_facility', 'escort_facility',
        'hostel_facility', 'hostel_type', 'hostel_schemes', 'special_training_facility',
        'remarks', 'cwsn_facility_receive', 'free_bicycle', 'free_shoe', 'exercise_book',
        
        // H. Bank Details
        'bank_name', 'branch_code', 'ifsc', 'account_no',
        
        // I. Upload Documents
        'aadhar_picture', 'birth_certificate', 'tc_certificate', 'social_certificate',
    ];

    protected $casts = [
        'dob' => 'date',
        'admission_date' => 'date',
    ];
}
