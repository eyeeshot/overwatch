<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use cURL;
use App\Models\Users\Users;
use App\Models\Users\Profiles;
use App\Models\Users\Playtimes;
use App\Models\Users\Stats;
use App\Models\Users\Hero_stats;
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
      $user->most = array();
      $most_arr = "";

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
          $most_3 = array();
          foreach ($most_arr as $key => $value){
            $most_3[] = $hero_img[$key];
            $i++;
            if($i==5){
              break;
            }
          }
          $user->most = $most_3;
        }

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
                    ->select(DB::RAW('users.id as id,users.battletag,DATE_FORMAT(profiles.created_at,"%Y-%m-%d") as profile_date,DATE_FORMAT(playtimes.created_at,"%Y-%m-%d") as playtimes_date,profiles.updated_at,profiles.id as profiles_id'))
                    ->leftJoin('profiles' , function($join) {
                            $join->on('profiles.id' , '=' , DB::RAW('(select a.id from profiles a where a.user_id = users.id order by a.created_at desc limit 1)'));
                        } , 'left inner')
                    ->leftJoin('playtimes' , function($join) {
                            $join->on('playtimes.id' , '=' , DB::RAW('(select b.id from playtimes b where b.user_id = users.id order by b.created_at desc limit 1)'));
                        } , 'left inner')
                    ->where('users.block_yn' , '=' , 'N')
                    ->get();
    foreach($users_arr AS $user) {
        $last_profile = Profiles::where('user_id', $user->id)->orderBy(DB::RAW('DATE_FORMAT(created_at,"%Y-%m-%d")'), 'DESC')->first();
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

          $last_competitive_play = is_object($last_profile)?$last_profile->competitive_play:0;
          $last_competitive_win = is_object($last_profile)?$last_profile->competitive_win:0;
          $last_competitive_losses = is_object($last_profile)?$last_profile->competitive_losses:0;
          $last_competitive_ties = is_object($last_profile)?$last_profile->competitive_ties:0;

          if($last_competitive_play != $json->kr->stats->competitive->overall_stats->games){

            if($user->profile_date == $today){
              echo "프로파일 패수";
              echo "<br>";
            }else{
              $profile = new Profiles;
              $profile->user_id = $user->id;
              $profile->level = intval($json->kr->stats->competitive->overall_stats->prestige * 100) + intval($json->kr->stats->competitive->overall_stats->level);
              $profile->competitive_win = $json->kr->stats->competitive->overall_stats->wins;
              $profile->competitive_daily_win = intval($json->kr->stats->competitive->overall_stats->wins) - intval($last_competitive_win);
              $profile->competitive_play = $json->kr->stats->competitive->overall_stats->games;
              $profile->competitive_playtime = $json->kr->stats->competitive->game_stats->time_played;
              $profile->competitive_rank = $json->kr->stats->competitive->overall_stats->comprank;
              $profile->competitive_winrate = $json->kr->stats->competitive->overall_stats->win_rate;
              $profile->competitive_losses = $json->kr->stats->competitive->overall_stats->losses;
              $profile->competitive_daily_losses = intval($json->kr->stats->competitive->overall_stats->losses) - intval($last_competitive_losses);
              $profile->competitive_ties = $json->kr->stats->competitive->overall_stats->ties;
              $profile->competitive_daily_ties = intval($json->kr->stats->competitive->overall_stats->ties) - intval($last_competitive_ties);
              $profile->competitive_tier = $json->kr->stats->competitive->overall_stats->comprank;
              $profile->created_at = $now_time;
              $profile->portrait = $file_name;
              $profile->save();
              $user->profiles_id = $profile->id;
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

            $last_stats = Stats::where('user_id', $user->id)->where(DB::RAW('DATE_FORMAT(created_at,"%Y-%m-%d")'), $today)->first();
            if(!trim($last_stats)){
              $stats = new Stats;
              $stats->user_id = $user->id;
              $stats->profiles_id = $user->profiles_id;
              $stats->win_rate = $json->kr->stats->competitive->overall_stats->win_rate;
              $stats->prestige = $json->kr->stats->competitive->overall_stats->prestige;
              $stats->games = $json->kr->stats->competitive->overall_stats->games;
              $stats->comprank = $json->kr->stats->competitive->overall_stats->comprank;
              $stats->tier = $json->kr->stats->competitive->overall_stats->tier;
              $stats->losses = $json->kr->stats->competitive->overall_stats->losses;
              $stats->wins = $json->kr->stats->competitive->overall_stats->wins;
              $stats->level = $json->kr->stats->competitive->overall_stats->level;
              $stats->damage_done_most_in_game = property_exists($json->kr->stats->competitive->game_stats,'all_damage_done_most_in_game')?$json->kr->stats->competitive->game_stats->all_damage_done_most_in_game:0;
              $stats->turrets_destroyed_most_in_game = property_exists($json->kr->stats->competitive->game_stats,'turrets_destroyed_most_in_game')?$json->kr->stats->competitive->game_stats->turrets_destroyed_most_in_game:0;
              $stats->objective_kills = property_exists($json->kr->stats->competitive->game_stats,'objective_kills')?$json->kr->stats->competitive->game_stats->objective_kills:0;
              $stats->time_spent_on_fire = property_exists($json->kr->stats->competitive->game_stats,'time_spent_on_fire')?$json->kr->stats->competitive->game_stats->time_spent_on_fire:0;
              $stats->eliminations_most_in_game = property_exists($json->kr->stats->competitive->game_stats,'eliminations_most_in_game')?$json->kr->stats->competitive->game_stats->eliminations_most_in_game:0;
              $stats->medals_bronze = property_exists($json->kr->stats->competitive->game_stats,'medals_bronze')?$json->kr->stats->competitive->game_stats->medals_bronze:0;
              $stats->games_won = property_exists($json->kr->stats->competitive->game_stats,'games_won')?$json->kr->stats->competitive->overall_stats->wins:0;
              $stats->games_lost = property_exists($json->kr->stats->competitive->game_stats,'games_lost')?$json->kr->stats->competitive->overall_stats->losses:0;
              $stats->teleporter_pad_destroyed_most_in_game = property_exists($json->kr->stats->competitive->game_stats,'teleporter_pad_destroyed_most_in_game')?$json->kr->stats->competitive->game_stats->teleporter_pad_destroyed_most_in_game:0;
              $stats->final_blows = property_exists($json->kr->stats->competitive->game_stats,'final_blows')?$json->kr->stats->competitive->game_stats->final_blows:0;
              $stats->deaths = property_exists($json->kr->stats->competitive->game_stats,'deaths')?$json->kr->stats->competitive->game_stats->deaths:0;
              $stats->time_spent_on_fire_most_in_game = property_exists($json->kr->stats->competitive->game_stats,'time_spent_on_fire_most_in_game')?$json->kr->stats->competitive->game_stats->time_spent_on_fire_most_in_game:0;
              $stats->medals_gold = property_exists($json->kr->stats->competitive->game_stats,'medals_gold')?$json->kr->stats->competitive->game_stats->medals_gold:0;
              $stats->offensive_assists_most_in_game = property_exists($json->kr->stats->competitive->game_stats,'offensive_assists_most_in_game')?$json->kr->stats->competitive->game_stats->offensive_assists_most_in_game:0;
              $stats->turrets_destroyed = property_exists($json->kr->stats->competitive->game_stats,'turrets_destroyed')?$json->kr->stats->competitive->game_stats->turrets_destroyed:0;
              $stats->objective_time_most_in_game = property_exists($json->kr->stats->competitive->game_stats,'objective_time_most_in_game')?$json->kr->stats->competitive->game_stats->objective_time_most_in_game:0;
              $stats->defensive_assists_most_in_game = property_exists($json->kr->stats->competitive->game_stats,'defensive_assists_most_in_game')?$json->kr->stats->competitive->game_stats->defensive_assists_most_in_game:0;
              $stats->melee_final_blows_most_in_game = property_exists($json->kr->stats->competitive->game_stats,'melee_final_blows_most_in_game')?$json->kr->stats->competitive->game_stats->melee_final_blows_most_in_game:0;
              $stats->recon_assists_most_in_game = property_exists($json->kr->stats->competitive->game_stats,'recon_assists_most_in_game')?$json->kr->stats->competitive->game_stats->recon_assists_most_in_game:0;
              $stats->healing_done = property_exists($json->kr->stats->competitive->game_stats,'healing_done')?$json->kr->stats->competitive->game_stats->healing_done:0;
              $stats->environmental_kills = property_exists($json->kr->stats->competitive->game_stats,'environmental_kills')?$json->kr->stats->competitive->game_stats->environmental_kills:0;
              $stats->multikills = property_exists($json->kr->stats->competitive->game_stats,'multikills')?$json->kr->stats->competitive->game_stats->multikills:0;
              $stats->environmental_deaths = property_exists($json->kr->stats->competitive->game_stats,'environmental_deaths')?$json->kr->stats->competitive->game_stats->environmental_deaths:0;
              $stats->eliminations = property_exists($json->kr->stats->competitive->game_stats,'eliminations')?$json->kr->stats->competitive->game_stats->eliminations:0;
              $stats->multikill_best = property_exists($json->kr->stats->competitive->game_stats,'multikill_best')?$json->kr->stats->competitive->game_stats->multikill_best:0;
              $stats->cards = property_exists($json->kr->stats->competitive->game_stats,'cards')?$json->kr->stats->competitive->game_stats->cards:0;
              $stats->objective_kills_most_in_game = property_exists($json->kr->stats->competitive->game_stats,'objective_kills_most_in_game')?$json->kr->stats->competitive->game_stats->objective_kills_most_in_game:0;
              $stats->offensive_assists = property_exists($json->kr->stats->competitive->game_stats,'offensive_assists')?$json->kr->stats->competitive->game_stats->offensive_assists:0;
              $stats->games_played = property_exists($json->kr->stats->competitive->game_stats,'games_played')?$json->kr->stats->competitive->game_stats->games_played:0;
              $stats->recon_assists = property_exists($json->kr->stats->competitive->game_stats,'recon_assists')?$json->kr->stats->competitive->game_stats->recon_assists:0;
              $stats->environmental_kills_most_in_game = property_exists($json->kr->stats->competitive->game_stats,'environmental_kills_most_in_game')?$json->kr->stats->competitive->game_stats->environmental_kills_most_in_game:0;
              $stats->kpd = property_exists($json->kr->stats->competitive->game_stats,'kpd')?$json->kr->stats->competitive->game_stats->kpd:0;
              $stats->damage_done = property_exists($json->kr->stats->competitive->game_stats,'damage_done')?$json->kr->stats->competitive->game_stats->damage_done:0;
              $stats->kill_streak_best = property_exists($json->kr->stats->competitive->game_stats,'kill_streak_best')?$json->kr->stats->competitive->game_stats->kill_streak_best:0;
              $stats->healing_done_most_in_game = property_exists($json->kr->stats->competitive->game_stats,'healing_done_most_in_game')?$json->kr->stats->competitive->game_stats->healing_done_most_in_game:0;
              $stats->solo_kills = property_exists($json->kr->stats->competitive->game_stats,'solo_kills')?$json->kr->stats->competitive->game_stats->solo_kills:0;
              $stats->final_blows_most_in_game = property_exists($json->kr->stats->competitive->game_stats,'final_blows_most_in_game')?$json->kr->stats->competitive->game_stats->final_blows_most_in_game:0;
              $stats->solo_kills_most_in_game = property_exists($json->kr->stats->competitive->game_stats,'solo_kills_most_in_game')?$json->kr->stats->competitive->game_stats->solo_kills_most_in_game:0;
              $stats->time_played = property_exists($json->kr->stats->competitive->game_stats,'time_played')?$json->kr->stats->competitive->game_stats->time_played:0;
              $stats->medals_silver = property_exists($json->kr->stats->competitive->game_stats,'medals_silver')?$json->kr->stats->competitive->game_stats->medals_silver:0;
              $stats->objective_time = property_exists($json->kr->stats->competitive->game_stats,'objective_time')?$json->kr->stats->competitive->game_stats->objective_time:0;
              $stats->defensive_assists = property_exists($json->kr->stats->competitive->game_stats,'defensive_assists')?$json->kr->stats->competitive->game_stats->defensive_assists:0;
              $stats->medals = property_exists($json->kr->stats->competitive->game_stats,'medals')?$json->kr->stats->competitive->game_stats->medals:0;
              $stats->games_tied = property_exists($json->kr->stats->competitive->game_stats,'games_tied')?$json->kr->stats->competitive->game_stats->games_tied:0;
              $stats->melee_final_blows = property_exists($json->kr->stats->competitive->game_stats,'melee_final_blows')?$json->kr->stats->competitive->game_stats->melee_final_blows:0;
              $stats->teleporter_pads_destroyed = property_exists($json->kr->stats->competitive->game_stats,'teleporter_pads_destroyed')?$json->kr->stats->competitive->game_stats->teleporter_pads_destroyed:0;

              $stats->save();
              $last_stats = new object;
              $last_stats->id = $stats->id;
            }else{
                echo "last : ".$last_stats;
            }

            foreach ($json->kr->heroes->stats->competitive as $key => $value) {
              if(Hero_Stats::where('user_id', $user->id)->where(DB::RAW('DATE_FORMAT(created_at,"%Y-%m-%d")'), $today)->where('stats_id', $last_stats->id)->where('hero', $key)->first()){
                echo "있다";
              }else{
                $hero_stats = new Hero_Stats;
                $hero_stats->type = "competitive";
                $hero_stats->user_id = $user->id;
                $hero_stats->stats_id = $last_stats->id;
                $hero_stats->hero = $key;
                $hero_stats->damage_done_most_in_game = property_exists($value->general_stats,'all_damage_done_most_in_game')?$value->general_stats->all_damage_done_most_in_game:0;
                $hero_stats->games_won = property_exists($value->general_stats,'games_won')?$value->general_stats->games_won:0;
                $hero_stats->self_healing_most_in_game = property_exists($value->general_stats,'self_healing_most_in_game')?$value->general_stats->self_healing_most_in_game:0;
                $hero_stats->time_spent_on_fire = property_exists($value->general_stats,'time_spent_on_fire')?$value->general_stats->time_spent_on_fire:0;
                $hero_stats->win_percentage = property_exists($value->general_stats,'win_percentage')?$value->general_stats->win_percentage:0;
                $hero_stats->solo_kills = property_exists($value->general_stats,'solo_kills')?$value->general_stats->solo_kills:0;
                $hero_stats->eliminations_per_life = property_exists($value->general_stats,'eliminations_per_life')?$value->general_stats->eliminations_per_life:0;
                $hero_stats->self_healing = property_exists($value->general_stats,'self_healing')?$value->general_stats->self_healing:0;
                $hero_stats->shots_fired = property_exists($value->general_stats,'shots_fired')?$value->general_stats->shots_fired:0;
                $hero_stats->medals_bronze = property_exists($value->general_stats,'medals_bronze')?$value->general_stats->medals_bronze:0;
                $hero_stats->objective_kills = property_exists($value->general_stats,'objective_kills')?$value->general_stats->objective_kills:0;
                $hero_stats->final_blows = property_exists($value->general_stats,'final_blows')?$value->general_stats->final_blows:0;
                $hero_stats->eliminations_most_in_life = property_exists($value->general_stats,'eliminations_most_in_life')?$value->general_stats->eliminations_most_in_life:0;
                $hero_stats->deaths = property_exists($value->general_stats,'deaths')?$value->general_stats->deaths:0;
                $hero_stats->time_spent_on_fire_most_in_game = property_exists($value->general_stats,'time_spent_on_fire_most_in_game')?$value->general_stats->time_spent_on_fire_most_in_game:0;
                $hero_stats->medals_gold = property_exists($value->general_stats,'medals_gold')?$value->general_stats->medals_gold:0;
                $hero_stats->games_lost = property_exists($value->general_stats,'games_lost')?$value->general_stats->games_lost:0;
                $hero_stats->critical_hits_most_in_life = property_exists($value->general_stats,'critical_hits_most_in_life')?$value->general_stats->critical_hits_most_in_life:0;
                $hero_stats->objective_time_most_in_game = property_exists($value->general_stats,'objective_time_most_in_game')?$value->general_stats->objective_time_most_in_game:0;
                $hero_stats->weapon_accuracy = property_exists($value->general_stats,'weapon_accuracy')?$value->general_stats->weapon_accuracy:0;
                $hero_stats->kill_streak_best = property_exists($value->general_stats,'kill_streak_best')?$value->general_stats->kill_streak_best:0;
                $hero_stats->critical_hit_accuracy = property_exists($value->general_stats,'critical_hit_accuracy')?$value->general_stats->critical_hit_accuracy:0;
                $hero_stats->healing_done = property_exists($value->general_stats,'healing_done')?$value->general_stats->healing_done:0;
                $hero_stats->critical_hits_most_in_game = property_exists($value->general_stats,'critical_hits_most_in_game')?$value->general_stats->critical_hits_most_in_game:0;
                $hero_stats->environmental_kills = property_exists($value->general_stats,'environmental_kills')?$value->general_stats->environmental_kills:0;
                $hero_stats->multikills = property_exists($value->general_stats,'multikills')?$value->general_stats->multikills:0;
                $hero_stats->environmental_deaths = property_exists($value->general_stats,'environmental_deaths')?$value->general_stats->environmental_deaths:0;
                $hero_stats->solo_kills_most_in_game = property_exists($value->general_stats,'solo_kills_most_in_game')?$value->general_stats->solo_kills_most_in_game:0;
                $hero_stats->weapon_accuracy_best_in_game = property_exists($value->general_stats,'weapon_accuracy_best_in_game')?$value->general_stats->weapon_accuracy_best_in_game:0;
                $hero_stats->multikill_best = property_exists($value->general_stats,'multikill_best')?$value->general_stats->multikill_best:0;
                $hero_stats->cards = property_exists($value->general_stats,'cards')?$value->general_stats->cards:0;
                $hero_stats->objective_kills_most_in_game = property_exists($value->general_stats,'objective_kills_most_in_game')?$value->general_stats->objective_kills_most_in_game:0;
                $hero_stats->games_played = property_exists($value->general_stats,'games_played')?$value->general_stats->games_played:0;
                $hero_stats->eliminations_most_in_game = property_exists($value->general_stats,'eliminations_most_in_game')?$value->general_stats->eliminations_most_in_game:0;
                $hero_stats->time_played = property_exists($value->general_stats,'time_played')?$value->general_stats->time_played:0;
                $hero_stats->healing_done_most_in_life = property_exists($value->general_stats,'healing_done_most_in_life')?$value->general_stats->healing_done_most_in_life:0;
                $hero_stats->damage_done = property_exists($value->general_stats,'damage_done')?$value->general_stats->damage_done:0;
                $hero_stats->damage_done_most_in_life = property_exists($value->general_stats,'damage_done_most_in_life')?$value->general_stats->damage_done_most_in_life:0;
                $hero_stats->healing_done_most_in_game = property_exists($value->general_stats,'healing_done_most_in_game')?$value->general_stats->healing_done_most_in_game:0;
                $hero_stats->shots_hit = property_exists($value->general_stats,'shots_hit')?$value->general_stats->shots_hit:0;
                $hero_stats->final_blows_most_in_game = property_exists($value->general_stats,'final_blows_most_in_game')?$value->general_stats->final_blows_most_in_game:0;
                $hero_stats->eliminations = property_exists($value->general_stats,'eliminations')?$value->general_stats->eliminations:0;
                $hero_stats->turrets_destroyed = property_exists($value->general_stats,'turrets_destroyed')?$value->general_stats->turrets_destroyed:0;
                $hero_stats->critical_hits = property_exists($value->general_stats,'critical_hits')?$value->general_stats->critical_hits:0;
                $hero_stats->medals_silver = property_exists($value->general_stats,'medals_silver')?$value->general_stats->medals_silver:0;
                $hero_stats->objective_time = property_exists($value->general_stats,'objective_time')?$value->general_stats->objective_time:0;
                $hero_stats->medals = property_exists($value->general_stats,'medals')?$value->general_stats->medals:0;
                $hero_stats->games_tied = property_exists($value->general_stats,'games_tied')?$value->general_stats->games_tied:0;
                $hero_stats->melee_final_blows = property_exists($value->general_stats,'melee_final_blows')?$value->general_stats->melee_final_blows:0;
                $hero_stats->teleporter_pads_destroyed = property_exists($value->general_stats,'teleporter_pads_destroyed')?$value->general_stats->teleporter_pads_destroyed:0;
                $hero_stats->time_spent_on_fire_average = property_exists($value->average_stats,'time_spent_on_fire_average')?$value->average_stats->time_spent_on_fire_average:0;
                $hero_stats->final_blows_average = property_exists($value->average_stats,'final_blows_average')?$value->average_stats->final_blows_average:0;
                $hero_stats->self_healing_average = property_exists($value->average_stats,'self_healing_average')?$value->average_stats->self_healing_average:0;
                $hero_stats->objective_kills_average = property_exists($value->average_stats,'objective_kills_average')?$value->average_stats->objective_kills_average:0;
                $hero_stats->critical_hits_average = property_exists($value->average_stats,'critical_hits_average')?$value->average_stats->critical_hits_average:0;
                $hero_stats->solo_kills_average = property_exists($value->average_stats,'solo_kills_average')?$value->average_stats->solo_kills_average:0;
                $hero_stats->melee_final_blows_average = property_exists($value->average_stats,'melee_final_blows_average')?$value->average_stats->melee_final_blows_average:0;
                $hero_stats->helix_rockets_kills_average = property_exists($value->average_stats,'helix_rockets_kills_average')?$value->average_stats->helix_rockets_kills_average:0;
                $hero_stats->objective_time_average = property_exists($value->average_stats,'objective_time_average')?$value->average_stats->objective_time_average:0;
                $hero_stats->damage_done_average = property_exists($value->average_stats,'damage_done_average')?$value->average_stats->damage_done_average:0;
                $hero_stats->healing_done_average = property_exists($value->average_stats,'healing_done_average')?$value->average_stats->healing_done_average:0;
                $hero_stats->tactical_visor_kills_average = property_exists($value->average_stats,'tactical_visor_kills_average')?$value->average_stats->tactical_visor_kills_average:0;
                $hero_stats->deaths_average = property_exists($value->average_stats,'deaths_average')?$value->average_stats->deaths_average:0;
                $hero_stats->eliminations_average = property_exists($value->average_stats,'eliminations_average')?$value->average_stats->eliminations_average:0;
                $hero_stats->save();
              }
            }
            sleep(10);
          }else{
            if($user->profile_date == $today){
              echo "프로파일 패수";
              echo "<br>";
            }else{
              $profile = new Profiles;
              $profile->user_id = $user->id;
              $profile->level = intval($json->kr->stats->competitive->overall_stats->prestige * 100) + intval($json->kr->stats->competitive->overall_stats->level);
              $profile->competitive_win = $json->kr->stats->competitive->overall_stats->wins;
              $profile->competitive_daily_win = intval($json->kr->stats->competitive->overall_stats->wins) - intval($last_profile->competitive_win);
              $profile->competitive_play = $json->kr->stats->competitive->overall_stats->games;
              $profile->competitive_playtime = $json->kr->stats->competitive->game_stats->time_played;
              $profile->competitive_rank = $json->kr->stats->competitive->overall_stats->comprank;
              $profile->competitive_winrate = $json->kr->stats->competitive->overall_stats->win_rate;
              $profile->competitive_losses = $json->kr->stats->competitive->overall_stats->losses;
              $profile->competitive_daily_losses = intval($json->kr->stats->competitive->overall_stats->losses) - intval($last_profile->competitive_losses);
              $profile->competitive_ties = $json->kr->stats->competitive->overall_stats->ties;
              $profile->competitive_daily_ties = intval($json->kr->stats->competitive->overall_stats->ties) - intval($last_profile->competitive_ties);
              $profile->competitive_tier = $json->kr->stats->competitive->overall_stats->comprank;
              $profile->created_at = $now_time;
              $profile->portrait = $file_name;
              $profile->save();
            }
          }
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
