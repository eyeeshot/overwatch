<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use cURL;
use App\Models\Users\Users;
use App\Models\Users\Profiles;
use App\Models\Tool\Common_Cds;
use Image;
use DB;

class MemberController extends Controller
{
  public function index() {
    $users = new Users();
    $users = $users->join('profiles' , function($join) {
                $join->on('profiles.id' , '=' , DB::RAW('(select a.id from profiles a where a.user_id = users.id order by a.created_at desc limit 1)'));
            } , 'left inner')
            ->orderBy('competitive_rank', 'DESC')
            ->get();


    foreach ($users as $user) {
      if($user->competitive_win){
        $user->competitive_per = round($user->competitive_win / $user->competitive_play * 100);
        $user->img_path = "portrait/".$user->portrait;
        $user->competitive_lost = $user->competitive_play - $user->competitive_win;
        $user->competitive_playtime = str_replace('hours', '시간',$user->competitive_playtime);
        $last_point_arr = new profiles;
        $last_point_arr = $last_point_arr->where('user_id','=',$user->user_id)->where('created_at','<',$user->created_at)->first();
        $user->change_rank = $user->competitive_rank - $last_point_arr->competitive_rank;
        if($user->change_rank<0){
          $user->change_rank_color = 'red';
        }elseif($user->change_rank==0){
          $user->change_rank_color = 'black';
          $user->change_rank = '-';
        }else{
          $user->change_rank_color = 'blue';
          $user->change_rank = '+'.$user->change_rank;
        }
      }
    }

    return view('member/index')->with('users' , $users);
  }

  public function total() {
    $curl = new cURL;
    $users = new Users();
    $users_arr = $users->where('block_yn' , '=' , 'N')->get();

    foreach($users_arr AS $user) {

        $name = str_replace('#','-',$user->battletag);
        $url = 'http://ow-api.herokuapp.com/profile/pc/kr/'.urlencode($name);
        $response = cURL::Get($url);
        $json = json_decode($response);

        if(is_object($json)){
          $portrait = basename($json->portrait);
          if($json->star){
            $level_star = basename($json->star);

            $level_star_cd = new Common_Cds;
            $level_star_cd = $level_star_cd->where('main_cd' , '=' , 'O0002')->where('use_yn','=','Y')->where('ref_1','=',$level_star)->first();

            if(count($level_star_cd) == 0){
              $img = Image::make($json->star);
              $img->save(storage_path()."/app/images/level_star/".$level_star);

              $common_cds_count = new Common_Cds;
              $common_cds_count = $common_cds_count->where('main_cd' , '=' , 'O0002')->count();

              $common_cds = new Common_cds;
              $common_cds->main_cd = 'O0002';
              $common_cds->det_cd = $common_cds_count;
              $common_cds->ref_1 = $level_star;
              $common_cds->name = '확인중';
              $common_cds->save();
              $level_star_cd_id = $common_cds_count;
            }else{
              $level_star_cd_id = $level_star_cd->det_cd;
            }
          }else{
            $level_star_cd_id = 0;
          }

          $img = Image::make($json->portrait);
          $img->save(storage_path()."/app/images/portrait/".$portrait);


          $profile = new Profiles;
          $profile->user_id = $user->id;
          $profile->level = $json->level;
          $profile->quickplay_win = $json->games->quickplay->wins;
          $profile->quickplay_play = $json->level;
          $profile->quickplay_playtime = $json->playtime->quickplay;
          $profile->competitive_win = $json->games->competitive->wins;
          $profile->competitive_play = $json->games->competitive->played;
          $profile->competitive_playtime = $json->playtime->competitive;
          $profile->competitive_rank = $json->competitive->rank;
          $profile->portrait = $portrait;
          $profile->level_star_cd = $level_star_cd_id;
          $profile->save();
        }else{
          echo $url;
        }
    }
    exit;

    return view('member/index');
  }
}
