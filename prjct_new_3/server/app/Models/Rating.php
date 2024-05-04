<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;


    protected $fillable = ['rating', 'user_id', 'activity_id',];



    public function activities()
    {
        return $this->belongsTo(Activity::class);
    }

    public function users()
    {

        return $this->belongsTo(User::class);
    }
}
