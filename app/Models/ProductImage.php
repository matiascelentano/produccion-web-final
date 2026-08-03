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

    protected function url(): Attribute
    {
        return Attribute::make(
            get: function () {
                //Verificando si la ruta es una URL completa
                if (str_starts_with($this->path, 'http')) {
                    return $this->path;
                }
                //Verificando si la ruta es una ruta de almacenamiento
                if (Storage::disk('public')->exists($this->path)) {
                    return Storage::disk('public')->url($this->path);
                }
                //Si la ruta no es una URL completa ni una ruta de almacenamiento, se asume que es una ruta relativa y se genera la URL completa utilizando la función asset()
                return asset($this->path);
            },
        );
}
}