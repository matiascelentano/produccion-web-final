<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    protected $fillable = ['name', 'email', 'password', 'role'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function orders(){
        return $this->hasMany(Order::class);
    }

    public function addresses(){
        return $this->hasMany(Address::class);
    }

    public function reviews(){
        return $this->hasMany(Review::class);
    }

    public function wishlist(){
        return $this->belongsToMany(Product::class, 'wishlists')->withTimestamps();
    }

    public function cart(){
        return $this->hasOne(Cart::class);
    }

    public function isAdmin(): bool{
        return $this->role === 'admin';
    }
}
