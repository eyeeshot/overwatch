<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;
use App\Models\Users\Hero_stats;
use DB;

class Stats extends Model
{
  protected $table = 'stats';

  protected $guarded = ['id'];

  public function Users()
  {
      return $this->belongsTo('App\Models\Users\Users','user_id','id');
  }

  public function Hero_stats()
  {
      return $this->hasMany(Hero_stats::class, 'stats_id');
  }

}
