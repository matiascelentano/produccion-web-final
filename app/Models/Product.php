<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
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