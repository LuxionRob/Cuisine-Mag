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
        return $this->belongsTo(Contact::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
