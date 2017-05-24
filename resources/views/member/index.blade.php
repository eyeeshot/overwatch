@extends('layout.master')

@section('content')

  <div class="page-header" id="banner">
    <div class="row">
      <div class="col-lg-12">
        <h1>Member</h1>
    </div>
    <div class="row">
      <div class="col-lg-12">
        <table class="table table-striped table-hover ">
          <thead>
            <tr>
              <th>#</th>
              <th>플레이어 (배틀태그)</th>
              <th>레벨</th>
              <th>경쟁전 (전일대비)</th>
              <th>플레이시간</th>
              <th>승/패(무)</th>
              <th style="width: 260px;">승률</th>
              <th style="width: 260px;">모스트</th>
            </tr>
          </thead>
          <tbody>
            @forelse($users as $indexKey => $user)
              <tr>
                <td>{{$indexKey+1}}</td>
                <td><img src='{{ url('/') }}/storage/images/{{$user->img_path}}' style="width:32px;"> {{$user->nick_name}} <font style='font-size:10px;'>({{$user->battletag}})</font></td>
                <td>LV.{{$user->level}}</td>
                <td>{{$user->competitive_rank}} <font style='font-size:10px; color:{{$user->change_rank_color}}'>( {{$user->change_rank}} )</font></td>
                <td>{{$user->competitive_playtime}}</td>
                <td> {{$user->competitive_win}} 승 {{$user->competitive_ties}} 무 {{$user->competitive_losses}} 패</td>
                <td>
                  <div style="inline:block">
                    <div style="height:4px;">
                      <div class="progress">
                        <div class="progress-bar progress-bar-success" style="width: {{$user->competitive_winrate}}%"></div>
                        <div class="progress-bar progress-bar-danger" style="width: {{100-$user->competitive_winrate}}%"></div>
                      </div>
                    </div>
                    <div style="margin-left:4px;">
                      {{$user->competitive_winrate}} %
                    </div>
                  </div>
                </td>
                <td>
                  @forelse($user->most as $most)
                    <img src='{{$most}}' style="width:32px;">
                  @empty
                    없음
                  @endforelse
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6"> 유저가 없습니다.</td>
              </tr>
	          @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>


@endsection
