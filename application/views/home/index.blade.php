<div class="row bg-light pt-2">
    <p class='p-2 h6 bg-secondary font-weight-bold text-light'><i class="fas fa-bell"></i> 공지 사항</p>
</div>
<div class="row bg-light pt-2">
    <div class="col">
        <ul class="list-unstyled">
        @foreach($notic as $item)
            <li><a href="javascript:" onclick="readBoard({{$item['BIdx']}}, '공지')" class="text-dark">{{$item['Title']}}</a></li>
        @endforeach
        </ul>
    </div>
</div>
<!-- 에약이 있으면 예약 항목 노출 -->
<div class="row bg-light">

    <p class='p-2 h6 bg-secondary font-weight-bold text-light'><i class="fas fa-chevron-circle-down"></i> 예약 내역</p>
    <?php
    if (isset($_SESSION['MemIdx'])) {
    ?>
    @if(count($order) > 0)
        <div class="row">
            <div class="col">
                수령일 : {{$order[0]['ReceiptDate']}}
            </div>
        </div>
        @foreach($orderProduct as $pitem)
            <div class="row">
                <div class="col">
                    {{$comcode[$util->rowsearch($comcode, 'ComCode', $pitem['FishCode'])]['ComName']}} /
                    {{$comcode[$util->rowsearch($comcode, 'ComCode', $pitem['ProdCode'])]['ComName']}} /
                    {{$comcode[$util->rowsearch($comcode, 'ComCode', $pitem['OriginCode'])]['ComName']}} /
                    {{$comcode[$util->rowsearch($comcode, 'ComCode', $pitem['KgCode'])]['ComName']}} / @if ($pitem['ReceiptStatus'] == 'Y') 수령 @else 미수령 @endif
                </div>
            </div>
        @endforeach
    <div class="p-1 text-center"><a href="/order" class="btn btn-outline-primary btn-sm">예약 확인하기</a></div>
    @else
        <div class="row pb-2">
            <div class="col text-center">예약내역이 없습니다.</div>
        </div>
        <div class="row pb-2">
            <div class="col text-center">
                <a href="/order/orderfrm" class="btn btn-outline-dark">예약하기</a>
            </div>
        </div>

    @endif
    <?php
    }else{
        ?>
    <div class="row p-2">
        <div class="col text-center">
            <a href="/login?ret=order" class="btn btn-outline-dark">예약하기</a>
        </div>
    </div>

    <?php
    }
    ?>
</div>

<!-- 에약이 있으면 예약 항목 노출 -->
<!-- 당일 재고가 있으면 재고 품목 노출 -->
<div class="row bg-light">
    <p class='p-2 h6 bg-secondary font-weight-bold text-light'><i class="fas fa-chevron-circle-down"></i> 전일 재고</p>
    @if(count($stock) > 0)
        <div class="col">
            <ul class="list-unstyled">
                @foreach($stock as $item)
                    <li><a href="javascript:" onclick="readBoard({{$item['BIdx']}}, '재고')" class="text-dark">{{$item['Title']}}</a></li>
                @endforeach
            </ul>
        </div>
    @else
        <div class="col p-3">전일 재고가 없습니다.</div>
    @endif
</div>
<!-- 당일 재고가 있으면 재고 품목 노출 -->
<div class="row bg-light">
    <p class='p-2 h6 bg-secondary font-weight-bold text-light'><i class="fas fa-chevron-circle-down"></i> 후기</p>
</div>
<?php

?>
<div class="row bg-light">
    @if(count($review) > 0)
        @foreach($review as $item)
            <div class="col-4 img-over bg-dark">
                <a href="/review/reviewdetail?bidx={{$item["BIdx"]}}"><img src="{{$item['path']}}/{{$item['ImageName']}}" style="width: 138px; height: 138px" onerror="this.src='/img/blank.png'"></a>
                <span class="rating text-light">★{{$item['Count']}}</span>
                <div class="afterNick text-light">{{$item['NickName']}}</div>
            </div>
        @endforeach
    @else
        <div class="col">
            작성된 후기가 없습니다<p></p>첫번째 후기 작성의 행운을 얻으시길 바랍니다!!
<?php
            if (isset($_SESSION['MemIdx'])) {
                $ReViewUrl = "/review?mode=write";
            }else{
                $ReViewUrl = "/login?ret=reviewwrite";
            }
?>
            <div class="col text-center">
                <a href="{{$ReViewUrl}}" class="btn btn-outline-dark">후기 작성하기</a>
            </div>
        </div>
    @endif

</div>
<script>
    function readBoard(bidx, title)
    {
        gfn_ajaxpost('/ajax/ajaxBoardRead', {bidx: bidx}, function (data){

            $("#ModalTitle").html(title);
            $("#BoardTitle").html(data[0]['Title'])
            $("#BoardRegDate").html(data[0]['RegDate'])
            $("#BoardContent").html(data[0]['Content'])
            $("#NoticModal").modal('show');
        });
    }
</script>

<div class="modal" id="NoticModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-secondary">
                <div class="row"><h5 class="modal-title text-light" id="ModalTitle">공지 사항</h5></div>
            </div>
            <div class="modal-body">
                <div class="row py-2">
                    <div class="col col-6" id="BoardTitle"></div>
                    <div class="col col-6 text-right" id="BoardRegDate"></div>
                </div>
                <hr class="sidebar-divider">
                <div class="row">
                    <div class="col" id="BoardContent">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="$('#NoticModal').modal('hide');">닫기</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-EVBF6FQS3B"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'G-EVBF6FQS3B');
</script>