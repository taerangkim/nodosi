
<div class="row bg-light pt-3">
    <div class="col col-3"><img src="/img/hangil.jpg" width="25"></div>
    <div class="col col-6 text-center" style="font-size: large;font-weight: bold">노도시</div>
    <!--
    <div class="col col-6 text-center" >
        <span style="font-size: large; font-weight: bold" class="text-primary">노</span>량진
        <span style="font-size: large; font-weight: bold" class="text-primary">도</span>매
        <span style="font-size: large; font-weight: bold" class="text-primary">시</span>장
    </div>
    -->
<?php
    if (isset($_SESSION['MemIdx'])) {
?>
    <div class="col col-3" style="text-align: right"><a href="/my" class="btn btn-dark btn-sm">내정보</a></div>
<?php
    }else{
?>
    <div class="col col-3" style="text-align: right"><a href="/login">로그인</a></div>
<?php

    }
?>
</div>
<div class="row bg-light pt-2">
    <ul class="nav nav-fill nav-tabs">
        <li class="nav-item"><a class="nav-link @if ($urlparams[0] =='' && !isset($urlparams[1])) active @endif" href="/" style="padding: 5px;height: 30px">홈</a></li>
        <li class="nav-item"><a class="nav-link @if ($urlparams[0] =='order') active @endif" href="/order" style="padding: 5px;height: 30px">예약</a></li>
        <li class="nav-item"><a class="nav-link @if ($urlparams[0] =='price') active @endif" href="/price" style="padding: 5px;height: 30px">시세</a></li>
        <li class="nav-item"><a class="nav-link @if ($urlparams[0] =='stock') active @endif" href="/stock" style="padding: 5px;height: 30px">재고현황</a></li>
        <li class="nav-item"><a class="nav-link @if ($urlparams[0] =='review') active @endif" href="/review" style="padding: 5px;height: 30px">후기</a></li>
    </ul>
</div>
