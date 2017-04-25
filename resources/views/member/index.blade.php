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
              <th>플레이어</th>
              <th>경쟁전</th>
              <th>플레이시간</th>
              <th>승률</th>
              <th>K/D</th>
              <th>평균폭주</th>
              <th>모스트</th>
              <th>직업</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>1</td>
              <th>eyeshot</th>
              <th><img src='https://overlog.gg/img/rankIcon/TierGrandMaster.png' width="25">4800</th>
              <th>312 시간</th>
              <th>82</th>
              <th>4.2</th>
              <th>1분20초</th>
              <th><img src="https://d1u1mce87gyfbn.cloudfront.net/game/heroes/small/0x02E0000000000042.png"  width="30" alt=""></th>
              <th>DPS</th>
            </tr>
            <tr>
              <td>2</td>
              <th>히릿</th>
              <th><img src='https://overlog.gg/img/rankIcon/TierGrandMaster.png'  width="25">4660</th>
              <th>22 시간</th>
              <th>42</th>
              <th>2.2</th>
              <th>20초</th>
              <th><img src="https://d1u1mce87gyfbn.cloudfront.net/game/heroes/small/0x02E000000000012E.png"  width="30" alt=""></th>
              <th>Supporting</th>
            </tr>
            <tr>
              <td>3</td>
              <th>별님</th>
              <th><img src='https://overlog.gg/img/rankIcon/TierGrandMaster.png' width="25">4600</th>
              <th>512 시간</th>
              <th>12</th>
              <th>8.2</th>
              <th>1초</th>
              <th><img src="https://d1u1mce87gyfbn.cloudfront.net/game/heroes/small/0x02E000000000007A.png" width="30" alt=""></th>
              <th>Supporting</th>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>


@endsection
