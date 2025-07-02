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
?>
<div class="card-body">
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
            <?php if ($prev_block > 0){?>
                <li class="page-item"><a class="page-link" href="javascript:void(0)" onclick="gopage(1)">처음</a></li>
            <?php } ?>
            <?php if ($prev_block > 0){?>
                <li class="page-item"><a class="page-link" href="javascript:void(0)" onclick="gopage({{$prev_block}})">이전</a></li>
            <?php } ?>
            <?php for($i = $prev_page; $i <= $next_block; $i++){?>
                <?php if($i != $page){?>
                    <li class="page-item"><a class="page-link" href="javascript:void(0)" onclick="gopage({{$i}})">{{$i}}</a></li>
                <?php }else{?>
                    <li class="page-item disabled"><a class="page-link" href="#">{{$i}}</a></li>
                <?php } ?>
            <?php } ?>
            <?php if ($next_page <= $last_page){?>
                <li class="page-item"><a class="page-link" href="javascript:void(0)" onclick="gopage({{$next_page}})">다음</a></li>
            <?php } ?>
            <?php if ($next_page <= $last_page){?>
                <li class="page-item"><a class="page-link" href="javascript:void(0)" onclick="gopage({{$last_page}})">마지막</a></li>
            <?php } ?>
        </ul>
    </nav>
</div>
<script>
    function gopage(page)
    {
        $("#page").val(page);
        frm = $("#page").parents('form')
        $(frm).submit();
    }
</script>