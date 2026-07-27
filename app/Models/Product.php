<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description', 'price', 'stock', 'image', 'active', 'brand_id'];

    protected $casts = [
        'price' => 'decimal:2',
        'active' => 'boolean',
    ];

    // Accessor: precio formateado con símbolo de moneda
    protected function priceFormatted(): Attribute{
        return Attribute::make(
            get: fn () => '$' . number_format($this->price, 2, ',', '.'),
        );
    }

    protected function stockStatus(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->stock > 0 ? 'En stock' : 'Sin stock',
        );
    }

    public function categories(){
        return $this->belongsToMany(Category::class);
    }

    public function brand(){
        return $this->belongsTo(Brand::class);
    }

    public function reviews(){
        return $this->hasMany(Review::class);
    }

    public function orderItems(){
        return $this->hasMany(OrderItem::class);
    }

    public function wishlistedBy(){
        return $this->belongsToMany(User::class, 'wishlists');
    }

    public function getRouteKeyName(){
        return 'slug';
    }

     public function images(){
        return $this->hasMany(ProductImage::class)->orderBy('order');
    }

    public function primaryImage(){
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }
}