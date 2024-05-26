<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;
    protected $fillable = [
        'activity_name', 'description','contact', 'price', 'picture', 'likes_count', 'comments_count',
        'rate_count', 'rate_sum', 'average_rate', 'location', 'activity_type_id', 'city_id', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function activityType()
    {
        return $this->belongsTo(ActivityType::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }


    public function activityPictures()
    {
        return $this->hasMany(ActivityPicture::class);
    }


    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }
}
