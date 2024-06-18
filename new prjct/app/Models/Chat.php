<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{   
    use HasFactory;
    protected $fillable = [ 'message','sender_id','receiver_id','isdeleted_sender','isdeleted_receiver'];

    public function sender()
    {
        return $this->hasMany(User::class);
    }

    public function receiver()
    {
        return $this->hasMany(User::class);
    }



}
