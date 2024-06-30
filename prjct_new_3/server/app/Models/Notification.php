<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $fillable = ['notification', 'receiver_id', 'activity_id'];

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    public function user()
    {

        return $this->belongsTo(User::class);
    }
}
