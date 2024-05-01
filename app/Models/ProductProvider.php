<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductProvider extends Model
{
    use HasFactory;
    protected $table = 'product_provider';

    protected $fillable = [
        'id',
        'product_id',
        'provider_id',
        'product_price',
        'product_stock',
    ];
}
