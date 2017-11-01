<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\User;

class File extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'original_name',
        'url',
    ];


    public function user() 
    {
        return $this->hasOne(User::class);
    }
        
}
