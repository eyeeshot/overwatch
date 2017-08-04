<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;
use DB;

class Profiles extends Model
{
  protected $table = 'profiles';

  protected $guarded = ['id'];

  public function Users()
  {
      return $this->belongsTo('App\Models\Users\Users','user_id','id');
  }
}
