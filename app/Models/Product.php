<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use CloudinaryLabs\CloudinaryLaravel\MediaAlly;

class Product extends Model
{
    use HasFactory;
    //use MediaAlly;

    //protected $table = 'products';

    protected $fillable = [
        'name',
        'ItemNumber',
        'price',
        'quantity',
        'description'
    ];

    public function files()
    {
        return $this->hasOne(File::class);
    }
}
