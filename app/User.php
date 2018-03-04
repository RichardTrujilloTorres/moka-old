<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Spatie\Permission\Traits\HasRoles;
use Laravel\Scout\Searchable;

use App\Profile;
use App\File;

use Storage;

use Carbon\Carbon;

class User extends Authenticatable
{
    use Notifiable, HasRoles, Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'last_logged_in',
    ];

    /**
     * Default space usage storage unit.
     *
     * @const string
     */
    const defaultStorageUnit = 'GB';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    // @tmp
    // @todo replace w/ role and permissions package
    /**
     * Is the user a/the admin?
     *
     * @return boolean
     */
    public function isAdmin()
    {
        return true;
    }

    public function buildProfile()
    {
        $profile = Profile::create([
            'user_id' => $this->id,
            // default which can be automatically initialized...
        ]);
        
        return $profile;
    }

    /**
     * Verifies than the user possesses a profile.
     *
     * @return boolean
     */
    public function hasProfile()
    {
        if (! $this->profile) {
            return false;
        }

        return true;
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    /**
     * Number of files belonging to the user.
     *
     * @return int
     */
    public function numberOfFiles()
    {
        // @todo make this more efficient
        return count($this->files);
    }

    /**
     * User's total server space usage in GB.
     *
     * @param string $unit
     * @return string
     */
    public function spaceUsed($unit = self::defaultStorageUnit)
    {
        $space = 0;
        foreach ($this->files as $file) {
            $space += Storage::size('files/'.$file->name);
        }

        return ($space / 1000)." KB";
    }
    
    public function lastLoggedIn()
    {
        if (! $this->last_logged_in) {
            return "Unknown";
        }

        return Carbon::createFromTimestamp(strtotime($this->last_logged_in))->diffForHumans();
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }

    /**
     * Is the user lock?.
     *
     * @return boolean
     */
    public function isLocked()
    {
        return ($this->locked === true || $this->locked === 1);
    }

    /**
     * UnLocks user out of the application according to specific settings.
     * This is not the same as unblocking the user.
     *
     * @return null
     */
    public function unlock()
    {
        $this->locked = false;
        $this->save();
    }

    /**
     * Locks user out of the application according to specific settings.
     * This is not the same as blocking the user.
     *
     * @return null
     */
    public function lock()
    {
        $this->locked = true;
        $this->save();
    }
}
