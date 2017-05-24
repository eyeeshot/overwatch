<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;
use App\Models\Users\Profiles;
use App\Models\Users\Playtimes;
use DB;

class Users extends Model
{
    protected $table = 'users';

    public function Profiles()
    {
        return $this->hasMany(Profiles::class, 'user_id');
    }

    public function Playtimes()
    {
        return $this->hasMany(Playtimes::class, 'user_id');
    }
}
