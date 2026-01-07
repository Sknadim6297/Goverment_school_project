<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admission extends Model
{
    use HasFactory;

    protected $fillable = [
        'admission_no',
        'admission_date',
        'name',
        'class',
        'section',
        'rollno',
        'stream',
        'guardian_name',
        'mobile_number',
        'total_fees',
        'paid_amount',
        'payment_status',
        'address',
        'date_of_birth',
        'photo',
    ];

    protected $casts = [
        'admission_date' => 'date',
        'date_of_birth' => 'date',
    ];

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function computerAdmission()
    {
        return $this->hasOne(ComputerAdmission::class);
    }

    public function saraswatiPujaFees()
    {
        return $this->hasMany(SaraswatiPujaFee::class);
    }
}
