<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;


    protected $fillable = ['cash', 'metode', 'number_card', 'date', 'status', 'code_ref'];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
