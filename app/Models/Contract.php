<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = [
        "subject",
        "provider",
        "price",
        "prepayment",
        "total_payment",
        "created_at",
        "expires_at",
        "contract_number",
        "status",
    ];
    protected $with = [
        "payment"
    ];

    public function payment ()
    {
        return $this->hasMany(Payment::class);
    }
}
