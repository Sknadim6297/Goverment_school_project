<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaraswatiPujaFee extends Model
{
    use HasFactory;

    protected $fillable = [
        'admission_id',
        'year',
        'fee_amount',
        'payment_date',
        'receipt_no',
        'payment_mode',
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
