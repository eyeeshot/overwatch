<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;
use App\Models\Users\Profiles;
use App\Models\Users\Playtimes;
use App\Models\Users\Stats;
use App\Models\Users\Hero_stats;
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

    public function Stats()
    {
        return $this->hasMany(Stats::class, 'user_id');
    }

    public function Hero_stats()
    {
        return $this->hasMany(hero_stats::class, 'user_id');
    }
}
