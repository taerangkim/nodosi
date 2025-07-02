<?php
$prev_block = (intval($page/10) -1) *10;
$prev_block += 1;
$prev_page = (intval($page/10)) *10;
$next_page = ((intval($page/10)) *10)+11;
$last_page = intval($Total/$pageingSize)+1;

//10,20... 10배수페이지 문제 처리
$fmod = $page%10;
if($fmod > 0){
  $prev_page += 1;
} else {
  $prev_page -= 9;
}
if($fmod > 0){
  $next_block = (intval($page/10) +1) *10;
} else {
  $next_block = (intval($page/10)) *10;
}

//10개의 페이지가 안될때 
if ($next_block > $last_page){
  $next_block = $last_page;
}

//검색조건값 전달
$search = @explode('&search&',$_SERVER['REQUEST_URI']);
if(@$search[1]){
  $search_V = $search[1];
} else {
  $search_V = '';
}

$search = @explode('&search&',$_SERVER['REQUEST_URI']);
$search2 = @explode('?',$_SERVER['REQUEST_URI']);
$c_search = @explode('?page',$_SERVER['REQUEST_URI']);
if(@$c_search[1]){
    $search_V = $search[1];
} else {
  if(@$search2[1]){
      $search_V = $search2[1];
    } else {
      $search_V = '';
    }
}
?>
<div class="card-body">
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
            <?php if ($prev_block > 0){?>
                <li class="page-item"><a class="page-link" href="?page=1&search&{{$search_V}}">처음</a></li>
            <?php } ?>
            <?php if ($prev_block > 0){?>
                <li class="page-item"><a class="page-link" href="?page={{$prev_block}}&search&{{$search_V}}">이전</a></li>
            <?php } ?>
            <?php for($i = $prev_page; $i <= $next_block; $i++){?>
                <?php if($i != $page){?>
                    <li class="page-item"><a class="page-link" href="?page={{$i}}&search&<?=$search_V?>">{{$i}}</a></li>
                <?php }else{?>
                    <li class="page-item disabled"><a class="page-link" href="#">{{$i}}</a></li>
                <?php } ?>
            <?php } ?>
            <?php if ($next_page <= $last_page){?>
                <li class="page-item"><a class="page-link" href="?page={{$next_page}}&search&{{$search_V}}">다음</a></li>
            <?php } ?>
            <?php if ($next_page <= $last_page){?>
                <li class="page-item"><a class="page-link" href="?page={{$last_page}}&search&{{$search_V}}">마지막</a></li>
            <?php } ?>
        </ul>
    </nav>
</div>