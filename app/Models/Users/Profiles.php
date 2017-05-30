<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;
use App\Models\Users\Stats;
use DB;

class Profiles extends Model
{
  protected $table = 'profiles';

  protected $guarded = ['id'];

  public function Users()
  {
      return $this->belongsTo('App\Models\Users\Users','user_id','id');
  }

  public function Stats()
  {
      return $this->hasMany(Stats::class, 'profiles_id');
  }

}
