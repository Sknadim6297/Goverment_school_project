<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Library extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'student_name',
        'registration_no',
        'class_name',
        'book_name',
        'issue_date',
        'return_date',
        'returning_on',
        'status',
        'remarks',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'return_date' => 'date',
        'returning_on' => 'date',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
