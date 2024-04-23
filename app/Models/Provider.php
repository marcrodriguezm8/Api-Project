<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    use HasFactory;

    protected $fillable = [
        'provider_name',
        'provider_phone',
        'provider_email',
        'provider_location',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
