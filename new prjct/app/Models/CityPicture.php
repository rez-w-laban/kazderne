<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CityPicture extends Model
{
    use HasFactory;


    protected $fillable = ['media',  'city_id',];

    public function city()
    {

        return $this->belongsTo(City::class);
    }
}
