<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\User;

class Profile extends Model
{
    protected $fillable = [
        'user_id', 
        'username',
        'first_name', 
        'last_name', 
        'avatar_url', 
        'company', 
        'address', 
        'country', 
        'city', 
        'zip_code', 
        'about', 
        'phrase', 
        'background_image_url',
    ];


    /**
     * Retrieve background url.
     *
     * @return string
     */
    public function backgroundImage()
    {
        if (! $this->background_image_url) {
            return '/assets/img/background.jpg';
        }

        $url = route('admin.users.background-image', $this->user->id);

        return $url;
    }

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
