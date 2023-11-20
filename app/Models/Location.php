<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'x',
        'y',
        'detail',
    ];

    public function contact()
    {
        return $this->hasMany(Order::class);
    }

    public function store()
    {
        return $this->hasMany(store::class);
    }
}
