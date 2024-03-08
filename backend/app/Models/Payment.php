<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;


    protected $fillable = ['cash', 'metode', 'number_card', 'code_ref'];

    public function trasactios()
    {
        return $this->hasMany(Transaction::class);
    }
}
