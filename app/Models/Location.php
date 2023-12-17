<?php

namespace App\Models;

use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;
    use SpatialTrait;

    protected $spatialFields = [
        'coordinate',
    ];
    protected $fillable = [
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
