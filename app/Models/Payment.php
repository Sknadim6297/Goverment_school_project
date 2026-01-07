<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'admission_id',
        'receipt_no',
        'amount',
        'payment_date',
        'payment_mode',
        'transaction_id',
        'remarks',
    ];

    protected $casts = [
        'payment_date' => 'date',
    ];

    public function admission()
    {
        return $this->belongsTo(Admission::class);
    }
}
