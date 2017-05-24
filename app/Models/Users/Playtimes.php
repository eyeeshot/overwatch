<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;
use DB;

class Playtimes extends Model
{
  protected $table = 'playtimes';

  protected $guarded = ['id'];

  public function Users()
  {
      return $this->belongsTo('App\Models\Users\Users','user_id','id');
  }

}
