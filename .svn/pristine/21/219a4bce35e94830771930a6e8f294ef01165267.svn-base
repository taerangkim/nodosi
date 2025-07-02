<link rel="stylesheet" href="/css/jquery-ui.css?cache=<?=date('Ymdmsi')?>">
<script src="/js/jquery-ui.js"></script>
<div style="background-color: #e0e0e0">
    <div class="card cardcolor1">
        <div class="card-body">
            <div class="card-title" style="font-size: small  ">
                <div class="row">
                    <div class="col" style="font-weight:bold;text-align: center ; vertical-align: middle;">
                        예약 정보 입력
                </div>

                    <div class="row">
                        <div class="col" style="font-weight:bold;vertical-align: middle;padding-bottom: 20px;">
                        1.예약은 오전8시부터 금일 자정까지 받습니다.<BR>
                        2.자연산또는 특수품목의 경우 당일 입하량 이나 가격의 변수등으로 인하여 물량이 없을수 있습니다.<BR>
                          자연산의 경우 주문스펙과 현장물건이 안맞을 경우 현장취소 가능합니다.<BR
                        3.예약분은 실명으로 계약금 5만 입금 수협 1010-2118-1674 (주)노도시 확인된분에 한해서만 예약처리 합니다.<BR>
                        4.예약자분들은 4시 이후 방문을 적극권장합니다. 경매받는 시간을 주셔야 합니다.<br>
                        </div>

                    </div>
                <div class="row">
                    <form method="post" action="/reserv/reservc" id="frm" name="frm">
                        <input type="hidden" name="reservmode" id="reservmode" value="{{$reservmode}}">
                        <input type="hidden" name="reservbidx" id="reservbidx" value="@if ($reservmode ==='up'){{$contentResult[0]['BIdx']}}@endif">
                        <div class="form-group row" style="border-top: solid #9d9d9d 1px; padding-bottom: 5px;padding-top: 5px">
                            <label class="col-sm-3 col-form-label">제목</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control form-control-sm" name="title" id="title" value="@if ($reservmode ==='up'){{$contentResult[0]['Title']}}@endif" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group row" style="border-top: solid #9d9d9d 1px;padding-bottom: 5px;padding-top: 5px">
                            <label class="col-sm-3 col-form-label">어종</label>
                            <div class="col-sm-9">
                                <select class="form-control form-control-sm" name="fishcode" id="fishcode" onchange="loadFishProd(this)">

                                    @if ($reservmode == 'up')
                                        @foreach ($array_1000 as $item)
                                            <option value="{{$item['ComCode']}}" @if ($contentResult[0]['FishCode'] == $item['ComCode']) selected @endif>{{ $item['ComValue']}}</option>
                                        @endforeach
                                    @else
                                        <option value="">어종</option>
                                        @foreach ($fishlist as $item)
                                            <option value="{{$item['ComCode']}}">{{ $item['ComValue']}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group row" style="border-top: solid #9d9d9d 1px; padding-bottom: 5px;padding-top: 5px">
                            <label class="col-sm-3 col-form-label">구분</label>
                            <div class="col-sm-9">
                                <select class="form-control form-control-sm" name="prodtypecode" id="prodtypecode" onchange="loadFishOrg(this)">
                                    <option value="">어종을 먼저 선택하시기 바랍니다.</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row" style="border-top: solid #9d9d9d 1px; padding-bottom: 5px;padding-top: 5px">
                            <label class="col-sm-3 col-form-label">원산지</label>
                            <div class="col-sm-9">
                                <select class="form-control form-control-sm" name="orgcode" id="orgcode" onchange="loadFishKg(this)">
                                    <option value="">구분을 먼저 선택하시기 바랍니다.</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row" style="border-top: solid #9d9d9d 1px; padding-bottom: 5px;padding-top: 5px">
                            <label class="col-sm-3 col-form-label">무게</label>
                            <div class="col-sm-9">
                                <select class="form-control form-control-sm" name="kgcode" id="kgcode">
                                    <option value="">원산지을 먼저 선택하시기 바랍니다.</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row" style="border-top: solid #9d9d9d 1px; padding-bottom: 5px;padding-top: 5px">
                            <label class="col-sm-3 col-form-label">수령방법</label>
                            <div class="col-sm-9">
                                <select class="form-control form-control-sm" name="receiptcode" id="receiptcode">

                                    @if ($reservmode == 'up')
                                        @foreach ($array_3300 as $item)
                                            <option value="{{$item['ComCode']}}" @if ($contentResult[0]['ReceiptCode'] == $item['ComCode']) selected @endif>{{ $item['ComValue']}}</option>
                                        @endforeach
                                    @else
                                        @foreach ($array_3300 as $item)
                                            @if ($loop->first)
                                                <option value="">{{ $item['ComValue']}}</option>
                                            @else
                                                <option value="{{$item['ComCode']}}">{{ $item['ComValue']}}</option>
                                            @endif
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group row" style="border-top: solid #9d9d9d 1px; padding-bottom: 5px;padding-top: 5px">
                            <label class="col-sm-3 col-form-label">수령일자</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control form-control-sm" name="receiptdate" id="receiptdate" value="@if ($reservmode ==='up') {{$contentResult[0]['ReceiptDate']}} @endif" autocomplete="off" readonly>
                            </div>
                        </div>
                        <!--
                        <div class="form-group row" style="border-top: solid #9d9d9d 1px; padding-bottom: 5px;padding-top: 5px">
                            <label class="col-sm-3 col-form-label">수령시간</label>
                            <div class="col-sm-9">
                                <select class="form-control form-control-sm" name="receipttime" id="receipttime">
                                    @if ($reservmode == 'up')
                                        @foreach ($array_1400 as $item)
                                            <option value="{{$item['ComCode']}}" @if ($contentResult[0]['ReceiptTimeCode'] == $item['ComCode']) selected @endif>{{ $item['ComValue']}}</option>
                                        @endforeach
                                    @else
                                        @foreach ($array_1400 as $item)
                                            @if ($loop->first)
                                                <option value="">{{ $item['ComValue']}}</option>
                                            @else
                                                <option value="{{$item['ComCode']}}">{{ $item['ComValue']}}</option>
                                            @endif
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        -->
                        <div class="form-group row" style="border-top: solid #9d9d9d 1px; padding-bottom: 5px;padding-top: 5px">
                            <label class="col-sm-3 col-form-label">연락처</label>
                            <div class="col-sm-9">
                                <input type="tel" class="form-control form-control-sm" name="telnum" id="telnum" value="@if ($reservmode ==='up') {{$contentResult[0]['TelNum']}} @endif" autocomplete="off" placeholder="전화번호 형식만 입력가능" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');" telOnly="true"/>
                            </div>
                        </div>
                        <div class="form-group row" style="border-top: solid #9d9d9d 1px; padding-bottom: 5px;padding-top: 5px">
                            <label for="contents" class="col-sm-3 col-form-label">추가내용</label>
                            <div class="col-sm-9">
                                <textarea class="form-control form-control-sm w-100" rows="10" style="max-width: 100%"  name="contents" id="contents">@if ($reservmode ==='up'){{$contentResult[0]['Content']}}@endif</textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <p></p>
                <div class="row">
                    <button type="button" class="form-control" class="btn" onclick="frmsubmit()">@if ($reservmode ==='up') 예약 수정 하기 @else 예약하기 @endif</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    @if ($reservmode=='up')
    $( function() {
        //loadFishKg();
    } );
    @endif
    $(document).on("keyup", "input[telOnly]", function() {$(this).val( $(this).val().replace(/[^0-9-]/gi,"") );});
    $.datepicker.setDefaults({
        dateFormat: 'yymmdd',
        prevText: '이전 달',
        nextText: '다음 달',
        monthNames: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
        monthNamesShort: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
        dayNames: ['일', '월', '화', '수', '목', '금', '토'],
        dayNamesShort: ['일', '월', '화', '수', '목', '금', '토'],
        dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
        showMonthAfterYear: true,
        yearSuffix: '년',
        minDate: 1,
        maxDate:15,

    });
    $( function() {
        $("#receiptdate").text(new Date().toLocaleDateString());
        $("#receiptdate").datepicker();

    } );
    function  frmsubmit()
    {
        hour = now.getHours()
        if (hour > 0 && hour < 7)
        {
            alert('예약 주문 시간이 종료되었습니다.\n 노도시의 예약시간은 08시 부터 24시까지 입니다.')
            return false;
        }
        if ($("#title").val() == "")
        {
            alert('제목을 입력하여 주시기 바랍니다.');
            return false;
        }
        if (getSelectIndex("fishcode") == 0)
        {
            alert('어종을 선택하여 주시기 바랍니다.');
            return false;
        }
        if (getSelectIndex("prodtypecode") == 0)
        {
            alert('구분을 선택하여 주시기 바랍니다.');
            return false;
        }
        if (getSelectIndex("orgcode") == 0)
        {
             alert('원산지를 선택하여 주시기 바랍니다.');
             return false;
        }
        if (getSelectIndex("kgcode") == 0)
        {
            alert('무개를 선택하여 주시기 바랍니다.');
            return false;
        }
        if (getSelectIndex("receiptcode") == 0)
        {
            alert('수령방법을 선택하여 주시기 바랍니다.');
            return false;
        }
        if ($("#receiptdate").val() == '')
        {
            alert('수령날짜을 선택하여 주시기 바랍니다.');
            return false;
        }
        // if (getSelectIndex("receipttime") == 0)
        // {
        //     alert('수령시간을 선택하여 주시기 바랍니다.');
        //     return false;
        // }
        if ($("#telnum").val() == '')
        {
            alert('연락처를 입력하여 주시기 바랍니다.')
            return  false;
        }
        if ($("#reservmode").val() == 'up')
        {
            msg = '예약 내용을 수정하시겠습니까?';
        }else
        {
            msg = '예약 내용을 등록하시겠습니까?';
        }
        if (confirm(msg))
        {
            $("#frm").submit();
        }
    }
    function getSelectIndex(objname)
    {
        console.log(objname);
        return  document.getElementById(objname).selectedIndex;
    }

    function loadFishProd(obj)
    {
        console.log($(obj).val());
        fishcode = $(obj).val();

        $("#prodtypecode").empty();
        jQuery.ajax({
            type:"POST",
            data: {
                fishcode : fishcode
            },
            dataType:"json",
            url:"/reserv/ajaxLoadFishProd",
            success : function(data) {
                console.log(data);
                $("#prodtypecode").append('<option value="">구분</option>');
                $.each(data, function(index, entry) {
                    $("#prodtypecode").append('<option value="' + entry['FRPROIdx'] + '_' + entry['ComCode'] + '">' + entry['ComName'] + '</option>');
                });

                @if ($reservmode=='up')
                //$("#prodtypecode").val('{{$contentResult[0]['KgCode']}}');
                @endif
            },
            complete : function(data) {
                // TODO
            },
            error : function(xhr, status, error) {
                alert("에러발생");
            }
        });

    }
    function loadFishOrg(obj)
    {
        console.log($(obj).val());
        FRPROIdx = $(obj).val();

        FRPROIdxArray = FRPROIdx.split('_');

        $("#orgcode").empty();

        jQuery.ajax({
            type:"POST",
            data: {
                FRPROIdx : FRPROIdxArray[0]
            },
            dataType:"json",
            url:"/reserv/ajaxLoadFishOrg",
            success : function(data) {
                console.log(data);
                $("#orgcode").append('<option value="">구분</option>');
                $.each(data, function(index, entry) {
                    $("#orgcode").append('<option value="' + entry['FORGIdx'] + '_' + entry['OrgCode'] + '">' + entry['ComName'] +'</option>');
                });

                @if ($reservmode=='up')
                //$("#prodtypecode").val('{{$contentResult[0]['KgCode']}}');
                @endif
            },
            complete : function(data) {
                // TODO
            },
            error : function(xhr, status, error) {
                alert("에러발생");
            }
        });
    }
    function loadFishKg(obj)
    {

        $("#kgcode").empty();
        FORGIdx = $(obj).val();
        FORGIdxArray = FORGIdx.split('_');
        jQuery.ajax({
            type:"POST",
            data: {
                FORGIdx : FORGIdxArray[0]
            },
            dataType:"json",
            url:"/reserv/ajaxLoadFishKg",
            success : function(data) {
                console.log(data);
                $("#kgcode").append('<option value="">무게</option>');
                $.each(data, function(index, entry) {
                    $("#kgcode").append('<option value="' + entry['ComCode'] + '">' + entry['Comvalue'] + '</option>');
                });
                @if ($reservmode=='up')
                    $("#kgcode").val('{{$contentResult[0]['KgCode']}}');
                @endif
            },
            complete : function(data) {
                // TODO
            },
            error : function(xhr, status, error) {
                alert("에러발생");
            }
        });
    }
    var now = new Date({{$nowdate}});   //현재시간
    now.setSeconds(now.getSeconds()+1);
    var ordertimer = setInterval(function ()
    {
        now.setSeconds(now.getSeconds()+1)

    }, 1000);
</script>

