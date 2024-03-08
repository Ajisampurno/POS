<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'date', 'status', 'product_id', 'payment_id'];

    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}
