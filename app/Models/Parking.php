<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parking extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $fillable = [
        'name', 'code', 'capacity', 'active', 'type_parkings_id', 'bike_count', 'stations_id'
    ];
}
