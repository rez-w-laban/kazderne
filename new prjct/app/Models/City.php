<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;


    protected $fillable = ['city_name', 'description', 'location', 'picture' ];



    public function activity()
    {
        return $this->hasMany(Activity::class);
    }

    public function cityPictures()
    {
        return $this->hasMany(CityPicture::class);
    }
}
