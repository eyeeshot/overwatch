<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;
use DB;

class Stats extends Model
{
  protected $table = 'stats';

  protected $guarded = ['id'];

  public function Users()
  {
      return $this->belongsTo('App\Models\Users\Users','user_id','id');
  }

  public function Profiles()
  {
      return $this->belongsTo('App\Models\Users\Profiles','profiles_id','id');
  }

}
