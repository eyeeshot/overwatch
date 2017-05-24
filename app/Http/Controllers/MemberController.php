<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use cURL;
use App\Models\Users\Users;
use App\Models\Users\Profiles;
use App\Models\Users\Playtimes;
use App\Models\Tool\Common_Cds;
use Image;
use DB;
use File;

class MemberController extends Controller
{
  public function index() {
    $hero_img = array(
                  'reaper' => 'https://blzgdapipro-a.akamaihd.net/game/heroes/small/0x02E0000000000002.png',
                  'tracer' => 'https://blzgdapipro-a.akamaihd.net/game/heroes/small/0x02E0000000000003.png',
                  'sombra' => 'https://blzgdapipro-a.akamaihd.net/game/heroes/small/0x02E000000000012E.png',
                  'mercy' => 'https://blzgdapipro-a.akamaihd.net/game/heroes/small/0x02E0000000000004.png',
                  'soldier76' => 'https://blzgdapipro-a.akamaihd.net/game/heroes/small/0x02E000000000006E.png',
                  'orisa' => 'https://blzgdapipro-a.akamaihd.net/game/heroes/small/0x02E000000000013E.png',
                  'winston' => 'https://blzgdapipro-a.akamaihd.net/game/heroes/small/0x02E0000000000009.png',
                  'ana' => 'https://blzgdapipro-a.akamaihd.net/game/heroes/small/0x02E000000000013B.png',
                  'torbjorn' => 'https://blzgdapipro-a.akamaihd.net/game/heroes/small/0x02E0000000000006.png',
                  'hanzo' => 'https://blzgdapipro-a.akamaihd.net/game/heroes/small/0x02E0000000000005.png',
                  'genji' => 'https://blzgdapipro-a.akamaihd.net/game/heroes/small/0x02E0000000000029.png',
                  'mei' => 'https://blzgdapipro-a.akamaihd.net/game/heroes/small/0x02E00000000000DD.png',
                  'zarya' => 'https://blzgdapipro-a.akamaihd.net/game/heroes/small/0x02E0000000000068.png',
                  'bastion' => 'https://blzgdapipro-a.akamaihd.net/game/heroes/small/0x02E0000000000015.png',
                  'symmetra' => 'https://blzgdapipro-a.akamaihd.net/game/heroes/small/0x02E0000000000016.png',
                  'pharah' => 'https://blzgdapipro-a.akamaihd.net/game/heroes/small/0x02E0000000000008.png',
                  'reinhardt' => 'https://blzgdapipro-a.akamaihd.net/game/heroes/small/0x02E0000000000007.png',
                  'roadhog' => 'https://blzgdapipro-a.akamaihd.net/game/heroes/small/0x02E0000000000040.png',
                  'lucio' => 'https://blzgdapipro-a.akamaihd.net/game/heroes/small/0x02E0000000000079.png',
                  'dva' => 'https://blzgdapipro-a.akamaihd.net/game/heroes/small/0x02E000000000007A.png',
                  'widowmaker' => 'https://blzgdapipro-a.akamaihd.net/game/heroes/small/0x02E000000000000A.png',
                  'zenyatta' => 'https://blzgdapipro-a.akamaihd.net/game/heroes/small/0x02E0000000000020.png',
                  'junkrat' => 'https://blzgdapipro-a.akamaihd.net/game/heroes/small/0x02E0000000000065.png',
                  'mccree' => 'https://blzgdapipro-a.akamaihd.net/game/heroes/small/0x02E0000000000042.png',
                );
    $users = new Users();
    $users = $users->where('block_yn','=','N');
    $users = $users->join('profiles' , function($join) {
                $join->on('profiles.id' , '=' , DB::RAW('(select a.id from profiles a where a.user_id = users.id order by a.created_at desc limit 1)'));
            } , 'left inner')
            ->orderBy(DB::RAW('DATE_FORMAT(profiles.created_at,"%Y-%m-%d")'), 'DESC')
            ->orderBy('competitive_rank', 'DESC')
            ->get();


    foreach ($users as $user) {
      if($user->competitive_win){
        $user->img_path = "portrait/".$user->portrait;
        $user->competitive_lost = $user->competitive_play - $user->competitive_win;
        $user->competitive_playtime = $user->competitive_playtime." 시간";
        $last_point_arr = new Profiles;
        $last_point_arr = $last_point_arr->where('user_id','=',$user->user_id)->where('created_at','<',$user->created_at)->orderBy('created_at', 'DESC')->first();
        $user->change_rank = $user->competitive_rank - $last_point_arr->competitive_rank;

        $most_arr = new Playtimes;
        $most_arr = $most_arr->select('reaper', 'tracer', 'sombra', 'mercy', 'soldier76', 'orisa', 'winston', 'ana', 'torbjorn', 'hanzo', 'genji', 'mei', 'zarya', 'bastion', 'symmetra', 'pharah', 'reinhardt', 'roadhog', 'lucio', 'dva', 'widowmaker', 'zenyatta', 'junkrat', 'mccree'
                    )->where('user_id','=',$user->user_id)->orderBy('created_at', 'DESC')->first();
        if(is_object($most_arr)){
          $most_arr = $most_arr->toArray();
          array_multisort($most_arr, SORT_DESC);
          $i = 0;
          foreach ($most_arr as $key => $value){
            $most_3[] = $hero_img[$key];
            $i++;
            if($i==5){
              break;
            }
          }
          $user->most = $most_3;
        }
        $most_3 = array();

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
    $today = date('Y-m-d',time());
    $now_time = date('Y-m-d h:m:s',time());

    $users_arr = $users
                    ->select(DB::RAW('users.id as id,users.battletag,DATE_FORMAT(profiles.created_at,"%Y-%m-%d") as profile_date,DATE_FORMAT(playtimes.created_at,"%Y-%m-%d") as playtimes_date,profiles.updated_at'))
                    ->leftJoin('profiles' , function($join) {
                            $join->on('profiles.id' , '=' , DB::RAW('(select a.id from profiles a where a.user_id = users.id order by a.created_at desc limit 1)'));
                        } , 'left inner')
                    ->leftJoin('playtimes' , function($join) {
                            $join->on('playtimes.id' , '=' , DB::RAW('(select b.id from playtimes b where b.user_id = users.id order by b.created_at desc limit 1)'));
                        } , 'left inner')
                    ->where('users.block_yn' , '=' , 'N')
                    ->get();
    foreach($users_arr AS $user) {
        $name = str_replace('#','-',$user->battletag);
        $url = 'https://owapi.net/api/v3/u/'.urlencode($name).'/blob';
        $curl = curl_init($url);

        curl_setopt($curl, CURLOPT_USERAGENT, "My User Agent Name");
        curl_setopt($curl, CURLOPT_FAILONERROR, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $html = curl_exec($curl);
        curl_close($curl);
        $json = json_decode($html);

        if(is_object($json)){
          $file_name = basename($json->kr->stats->competitive->overall_stats->avatar);
          $path = storage_path('/app/images/portrait/' . $file_name);


          if (!File::exists($path)) {
            $img = Image::make($json->kr->stats->competitive->overall_stats->avatar);
            $img->save($path);
          }

          if($user->profile_date == $today){
            echo "프로파일 패수";
            echo "<br>";
          }else{
            $profile = new Profiles;
            $profile->user_id = $user->id;
            $profile->level = intval($json->kr->stats->competitive->overall_stats->prestige * 100) + intval($json->kr->stats->competitive->overall_stats->level);
            $profile->quickplay_win = $json->kr->stats->quickplay->overall_stats->wins;
            $profile->quickplay_play = $json->kr->stats->quickplay->overall_stats->games;
            $profile->quickplay_playtime = $json->kr->stats->quickplay->game_stats->time_played;
            $profile->competitive_win = $json->kr->stats->competitive->overall_stats->wins;
            $profile->competitive_play = $json->kr->stats->competitive->overall_stats->games;
            $profile->competitive_playtime = $json->kr->stats->competitive->game_stats->time_played;
            $profile->competitive_rank = $json->kr->stats->competitive->overall_stats->comprank;
            $profile->competitive_winrate = $json->kr->stats->competitive->overall_stats->win_rate;
            $profile->competitive_losses = $json->kr->stats->competitive->overall_stats->losses;
            $profile->competitive_ties = $json->kr->stats->competitive->overall_stats->ties;
            $profile->competitive_tier = $json->kr->stats->competitive->overall_stats->comprank;
            $profile->created_at = $now_time;
            $profile->portrait = $file_name;
            $profile->save();
          }

          if($user->playtimes_date == $today){
            echo "플레이타임 패수";
            echo "<br>";
          }else{
            $playtime = new Playtimes;
            $playtime->user_id = $user->id;
            $playtime->type = "competitive";
            $playtime->reaper = $json->kr->heroes->playtime->competitive->reaper;
            $playtime->tracer = $json->kr->heroes->playtime->competitive->tracer;
            $playtime->sombra = $json->kr->heroes->playtime->competitive->sombra;
            $playtime->mercy = $json->kr->heroes->playtime->competitive->mercy;
            $playtime->soldier76 = $json->kr->heroes->playtime->competitive->soldier76;
            $playtime->orisa = $json->kr->heroes->playtime->competitive->orisa;
            $playtime->winston = $json->kr->heroes->playtime->competitive->winston;
            $playtime->ana = $json->kr->heroes->playtime->competitive->ana;
            $playtime->torbjorn = $json->kr->heroes->playtime->competitive->torbjorn;
            $playtime->hanzo = $json->kr->heroes->playtime->competitive->hanzo;
            $playtime->genji = $json->kr->heroes->playtime->competitive->genji;
            $playtime->mei = $json->kr->heroes->playtime->competitive->mei;
            $playtime->zarya = $json->kr->heroes->playtime->competitive->zarya;
            $playtime->bastion = $json->kr->heroes->playtime->competitive->bastion;
            $playtime->symmetra = $json->kr->heroes->playtime->competitive->symmetra;
            $playtime->pharah = $json->kr->heroes->playtime->competitive->pharah;
            $playtime->reinhardt = $json->kr->heroes->playtime->competitive->reinhardt;
            $playtime->roadhog = $json->kr->heroes->playtime->competitive->roadhog;
            $playtime->lucio = $json->kr->heroes->playtime->competitive->lucio;
            $playtime->dva = $json->kr->heroes->playtime->competitive->dva;
            $playtime->widowmaker = $json->kr->heroes->playtime->competitive->widowmaker;
            $playtime->zenyatta = $json->kr->heroes->playtime->competitive->zenyatta;
            $playtime->junkrat = $json->kr->heroes->playtime->competitive->junkrat;
            $playtime->mccree = $json->kr->heroes->playtime->competitive->mccree;
            $playtime->created_at = $now_time;
            $playtime->save();
          }
          sleep(10);




        }else{
          echo $url;
          echo "<br>";
        }
    }
    echo "Done";
    exit;
    return view('member/index');
  }
}
