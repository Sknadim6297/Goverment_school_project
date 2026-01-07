<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComputerAdmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'admission_id',
        'enrollment_date',
        'course_name',
        'course_fee',
        'paid_amount',
        'payment_status',
        'start_date',
        'end_date',
        'remarks',
        'computer_fees',
        'book_fees',
        'miscellaneous_fees',
        'payment_date',
        'payment_mode',
    ];

    protected $casts = [
        'enrollment_date' => 'date',
        'start_date' => 'date',
        'end_date' => 'date',
        'payment_date' => 'date',
    ];

    public function admission()
    {
        return $this->belongsTo(Admission::class);
    }
}
