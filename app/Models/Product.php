<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['uid', 'name', 'description', 'price', 'stock'];

    protected $hidden = ['id']; // Sembunyikan id dari response API

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($product) {
            $product->uid = Str::uuid()->toString(); // Generate UID saat membuat produk baru
        });
    }
}
