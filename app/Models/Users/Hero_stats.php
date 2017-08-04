<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;
use DB;

class Hero_stats extends Model
{
  protected $table = 'hero_stats';

  protected $guarded = ['id'];

  public function Users()
  {
      return $this->belongsTo('App\Models\Users\Users','user_id','id');
  }

  public function Stats()
  {
      return $this->belongsTo('App\Models\Users\Stats','stats_id','id');
  }

}
