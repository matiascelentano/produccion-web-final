<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ProductImage extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'path', 'order', 'is_primary'];

    protected $casts = [
        'is_primary' => 'boolean',
    ];

    public function product(){
        return $this->belongsTo(Product::class);
    }

    // Accessor para la URL completa
    protected function url(): Attribute{
        return Attribute::make(
            get: fn () => str_starts_with($this->path, 'http') ? $this->path : asset($this->path),
        );
    }
}