<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;


    protected $fillable = ['desc', 'category', 'stock', 'price'];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
