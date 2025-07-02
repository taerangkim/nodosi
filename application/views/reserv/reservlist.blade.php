<link rel="stylesheet" href="/css/jquery-ui.css">
<script src="/js/jquery-ui.js"></script>
<script type="text/javascript">
    function reply(Bidx)
    {
        $("#replymode").val('ins');
        $("#bidx").val(Bidx);
        $('#reply').modal('show');
    }
    function replySubimt()
    {
        if($("#replyContent").val() == '')
        {
            alert('댓글을 작성하여 주시기 바랍니다.');
            return false;
        }
        if(confirm('댓글을 등록하시겠습니까?')) {
            $("#replyfrm").submit();
        }
    }
    function deleteReply(BRIdx, BIdx)
    {
        if(confirm('해당 댓글을 삭제 하시겠습니까?'))
        {
            $("#replymode").val('del');
            $("#bidx").val(BIdx);
            $("#bridx").val(BRIdx);
            $("#replyfrm").submit();
        }
    }
    function modifyReply(BRIdx, BIdx) {
        $("#replyContent").val($("#reply" + BRIdx).text());
        $('#reply').modal('show');
        $("#replymode").val('up');
        $("#bidx").val(BIdx);
        $("#bridx").val(BRIdx);
    }
    function deleteReserv(BIdx){
        if(confirm('해당 예약을 삭제 하시겠습니까?'))
        {
            $("#reservfrm").attr('action','/reserv/reservc');
            $("#reservbidx").val(BIdx);
            $("#reservmode").val("del");
            $("#reservfrm").submit();
        }
    }
    function modifyReserv(BIdx){
        $("#reservbidx").val(BIdx);
        $("#reservfrm").submit();
    }
    function goReserv()
    {
        document.location.href='/reserv/reservfrm';
    }


</script>
<div  style="background-color: #e0e0e0">
    <form method="post" action="/reserv/reservfrm" id="reservfrm" name="reservfrm">
        <input type="hidden" name="reservbidx" id="reservbidx" value="">
        <input type="hidden" name="reservmode" id="reservmode" value="up">
    </form>
    <div class="row">
        <button type="button" class="form-control" class="btn" onclick="goReserv()">예약하기</button>
    </div>
    <div class="row">
        <div class="col" style="font-weight:bold;vertical-align: middle;padding-bottom: 20px;">
            1.예약은 오전8시부터 금일 자정까지 받습니다.<BR>
            2.자연산또는 특수품목의 경우 당일 입하량 이나 가격의 변수등으로 인하여 물량이 없을수 있습니다.<BR>
            자연산의 경우 주문스펙과 현장물건이 안맞을 경우 현장취소 가능합니다.<BR>
            3.예약분은 실명으로 계약금 5만 입금 수협 1010-2118-1674 (주)노도시 확인된분에 한해서만 예약처리 합니다.<BR>
            4.예약자분들은 4시 이후 방문을 적극권장합니다. 경매받는 시간을 주셔야 합니다.<br>
        </div>
    </div>
    @foreach ($result as $item)
        <div class="card cardcolor1">
            <div class="card-body">
                <div class="row radius5px">
                    <div class="col">
                        <div class="row reply radiusTop5px">
                            <div class="col col-3">어종</div>
                            <div class="col col-3">{{$comcode[$util->rowsearch($comcode, 'ComCode', $item['FishCode'])]['ComName']}}</div>
                            <div class="col col-3">원산지</div>
                            <div class="col col-3">{{$comcode[$util->rowsearch($comcode, 'ComCode', $item['OriginCode'])]['ComName']}}</div>
                        </div>
                        <div class="row reply">
                            <div class="col col-3">무게</div>
                            <div class="col col-3">{{$comcode[$util->rowsearch($comcode, 'ComCode', $item['KgCode'])]['ComName']}}</div>
                            <div class="col col-3">수령방법</div>
                            <div class="col col-3">{{$comcode[$util->rowsearch($comcode, 'ComCode', $item['ReceiptCode'])]['ComName']}}</div>
                        </div>
                        <div class="row reply radiusBottom5px">
                            <div class="col col-3">수령일</div>
                            <div class="col col-3">{{$item['ReceiptDate']}}</div>
                            <div class="col col-3">&nbsp;</div>
                            <div class="col col-3">&nbsp;</div>
                        </div>
                    </div>
                </div>
                <p></p>
                <div class="row">
                    <div class="col col-3">제목</div>
                    <div class="col col-6">{{$item['Title']}}</div>
                    <div class="col col-3">
                        <button type="button" class="form-control" class="btn" style="font-size: x-small" onclick="deleteReserv({{$item['BIdx']}})">
                            <span class="fas fa-times-circle fa-lg" aria-hidden="true" style="color:red;"></span>&nbsp;&nbsp;&nbsp;삭제
                        </button>
                    </div>
                </div>
                <div class="row">
                    <div class="col col-3">작성일</div>
                    <div class="col col-6">{{$item['RegDate']}}</div>
                    <div class="col col-3">
                        <button type="button" class="form-control" class="btn" style="font-size: x-small" onclick="modifyReserv({{$item['BIdx']}})">
                            <span class="fas fa-edit fa-lg" aria-hidden="true" style="color:dodgerblue;"></span>&nbsp;&nbsp;&nbsp;수정
                        </button>
                    </div>
                </div>
                <p></p>
                <div class="row">
                    <div class="col radius5px" style="min-height: 100px;padding-top:10px;padding-bottom: 10px">
                        <?=$item['Content'];?>
                    </div>
                </div>
                <p></p>
                <div class="row" style="padding-left: 5px;padding-right: 5px">
                    <div class="col">
                    @foreach($util->array_search($replyResult, 'BIdx', $item['BIdx']) as $replyitem)
                        <div class="row radiusTop5px" style="background: #ffffff;padding-top:15px;border-top: solid 1px black; border-left: solid 1px black; border-right: solid 1px black">
                            <div class="col col-6"><i class="fas fa-greater-than" style="color:dodgerblue;">&nbsp;</i>
                            @if ($item['MemIdx'] == $replyitem['MemIdx'])
                                본인
                            @else
                                {{$replyitem['NickName']}}
                            @endif
                            </div>
                            <div class="col col-6" style="text-align: right">{{$replyitem['RegDate']}}{{$replyitem['BRIdx']}}</div>
                        </div>
                        <div class="row" style="background: #ffffff;border-right: solid 1px black; border-left: solid 1px black;min-height: 50px;padding-top:10px;padding-bottom: 10px;">
                            <div class="col" id="reply{{$replyitem['BRIdx']}}"><?=$replyitem['Contents'];?></div>
                        </div>
                        @if ($item['MemIdx'] == $replyitem['MemIdx'])
                        <div class="row " style="background: #ffffff;border-left: solid 1px black; border-right: solid 1px black; padding-bottom: 10px">
                            <div class="col col-6">
                                <button type="button" class="form-control" class="btn" style="font-size: x-small" onclick="deleteReply({{$replyitem['BRIdx']}},{{$replyitem['BIdx']}})">
                                    <span class="fas fa-times-circle fa-lg" aria-hidden="true" style="color:red;"></span>&nbsp;&nbsp;&nbsp;삭제
                                </button>
                            </div>
                            <div class="col col-6">
                                <button type="button" class="form-control" class="btn" style="font-size: x-small" onclick="modifyReply({{$replyitem['BRIdx']}},{{$replyitem['BIdx']}})">
                                    <span class="fas fa-edit fa-lg" aria-hidden="true" style="color:dodgerblue;"></span>&nbsp;&nbsp;&nbsp;수정
                                </button>
                            </div>
                        </div>
                        @endif
                            <div class="row radiusBottom5px" style="background: #ffffff;height: 5px;padding-bottom: 10px;border-bottom: solid 1px black;border-left: solid 1px black; border-right: solid 1px black;">
                                <div class="col"></div>
                            </div>
                        <p></p>
                    @endforeach
                    </div>
                </div>
                <div class="row" style="padding-top:10px">
                    <button type="button" class="form-control" class="btn" onclick="reply({{$item['BIdx']}})">댓글 작성하기</button>
                </div>
            </div>
        </div>
        <p></p>
    @endforeach
</div>

<div class="modal fade" id="reply" tabindex="-1" style="font-size: small">
    <form method="post" action="/reserv/reservrc" id="replyfrm" name="replyfrm">
        <input type="hidden" name="bidx" id="bidx" value="">
        <input type="hidden" name="bridx" id="bridx" value="">
        <input type="hidden" name="replymode" id="replymode" value="ins">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"  style="font-size: small">댓글 작성</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <textarea class="form-control" id="replyContent" name="replyContent" rows="5"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" style="font-size: small" onclick="$('#reply').modal('hide');">닫기</button>
                    <button type="button" class="btn btn-primary" style="font-size: small" onclick="replySubimt()">저장</button>
                </div>
            </div>
        </div>
    </form>
</div>
