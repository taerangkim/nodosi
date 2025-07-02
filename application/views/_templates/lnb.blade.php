<?php
$MenuAuth = str_replace('|',',',@$MenuAuth[0][AuthMenuJson]);
$MenuAuth = str_replace(':',',',@$MenuAuth);
$MenuAuth2 = explode(',',$MenuAuth);
$REQUEST_URI = $_SERVER['REQUEST_URI'];
?>
<ul class="navbar-nav sidebar sidebar-dark bg-dark">
    @foreach ($MenuLeft as $rows=>$item)
    @if (array_search ($item['MenuIdx'], $MenuAuth2))
    @if ($item["MenuDepth"] == 0 )
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
        <div class="sidebar-brand-text mx-3">윌비스 통합 정산<br>{{$item['MenuName']}}</div>
    </a>
    @endif
    @if ($item["MenuDepth"] == 1 )
    <hr class="sidebar-divider d-none d-md-block">
    <li class="nav-item">
        <span class="nav-link"><a class="nav-link subnav @if (trim($item['MenuUrl']) == $REQUEST_URI) font-italic font-weight-bold text-warning @endif" href="{{trim($item['MenuUrl'])}}">{{$item['MenuName']}}</a></span>
    </li>
    @endif
    @if ($item["MenuDepth"] == 2 )
    <li class="nav-item subitem">
        <a class="nav-link subnav @if (trim($item['MenuUrl']) == $REQUEST_URI) font-italic font-weight-bold text-warning @endif" href="{{trim($item['MenuUrl'])}}">{{$item['MenuName']}}</a>
    </li>
    @endif
    @endif
    @endforeach
    <hr class="sidebar-divider">

</ul>