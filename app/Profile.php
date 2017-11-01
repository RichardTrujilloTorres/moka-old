<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\User;

class Profile extends Model
{
    protected $fillable = [
        'user_id', 'first_name', 'last_name', 'avatar_url', 'company', 'address', 'city', 'zip_code', 'about', 
        'phrase', 
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getPhrase()
    {
        if ($this->phrase === '' || null === $this->phrase) {
            return null;
        }

        return '"'.$this->phrase.'"';
    }

    public function getCompany()
    {
        if (empty($this->company)) {
            return "No company";
        }

        return $this->company;
    }

    public function fullName()
    {
        return $this->first_name.' '.$this->last_name;
    }
}
