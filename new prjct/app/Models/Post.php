<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    protected $fillable = ['description', 'media','likes_count','comments_count', 'user_id', 'activity_id'];

    use HasFactory;
    
    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    public function user()
    {

        return $this->belongsTo(User::class);
    }
}
