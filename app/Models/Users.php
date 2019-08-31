<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class Users.
 *
 * @package namespace App\Models;
 */
class Users extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
    protected $table = 'users';

    protected $guarded = [];

    protected $hidden = [
        'pwd', 'remember_token',
    ];

    const status_invalid = 0;
    const status_valid = 1;
    const status_disabled = 9;

    const lock_status_invalid = 0;
    const lock_status_unlock = 1;
    const lock_status_locked = 2;

    public function findForPassport($login)
    {
        return $this->orWhere('login_id', $login)
                ->where('lock_status', self::lock_status_unlock)->first();
    }

    public function setPasswordAttribute($passowrd)
    {
        $this->attributes['pwd'] = hash('sha256', $passowrd);
    }

    public function getAuthPassword(){
        return $this->attributes['pwd'];
    }

    public function validateForPassportPasswordGrant($password){
        return hash('sha256', $password) == $this->getAuthPassword();
    }

}
