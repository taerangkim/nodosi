<!-- 오늘 시세 정보 가지고 나오기 -->
<script>
    var SESSION_TIMER;
    $(document).on("keyup", "#callNum", function() {
        $(this).val( $(this).val().replace(/[^0-9]/g, "").replace(/(^1[0-9]{3}|^0[0-9]{2})([0-9]+)?([0-9]{4})$/,"$1-$2-$3").replace("--", "-") );
    });
    function setAuth()
    {
        gfn_ajaxpost(
            '/ajax/ajaxSetAuth',
            {callNum : $("#callNum").val()},
            function (data) {
                if (data['result'] == 'ok')
                {
                    alert("인증 번호가 발송되었습니다. \n문자 메세지를 확인 하여 주시기 바랍니다.\n");
                    authCount();
                }
            });
    }
    function frmsubmit(rtype)
    {
        if($("#callNum").val() == '')
        {
            alert('전화번호를 입력하여 주시기 바랍니다.');
            return;
        }
        $("#rtype").val(rtype);
        var trans_num = $("#callNum").val();
        if(trans_num.length==13 || trans_num.length==12)
        {
            // 유효성 체크
            var regExp = /^(?:(010-\d{4})|(01[1|6|7|8|9]-\d{3,4}))-(\d{4})$/;
            if(regExp.test(trans_num))
            {
                $("#frm").submit();
            }
            else
            {
                alert("유효하지 않은 전화번호 입니다.");
                return;
            }
        }
        else
        {
            alert("유효하지 않은 전화번호 입니다.");
            return;
        }
    }

    function authCount() {
        var SESSION_TIME = 180;
        var SESSION_MIN = "";
        var SESSION_SEC = "";

        SESSION_TIMER = setInterval(function () {
            SESSION_MIN = parseInt(SESSION_TIME / 60);
            SESSION_SEC = SESSION_TIME % 60;
            if (SESSION_MIN < 10) SESSION_MIN = "0" + SESSION_MIN;
            if (SESSION_SEC < 10) SESSION_SEC = "0" + SESSION_SEC;
            $("#remainTime").html(SESSION_MIN + "분" + SESSION_SEC + "초");
            SESSION_TIME--;
            if (SESSION_TIME < 0) {
                alert('인증 번호 기간이 만료 되었습니다.\n 인증 번호를 재발송 받으시길 바랍니다.');
                clearInterval(SESSION_TIMER);
            }
        }, 1000);
    }

</script>
<div class="row bg-light pt-3">
    <div class="card cardcolor1">
        <div class="card-body">
            <div class="card-title" style="font-size: small  ">
                <div class="row">
                    <div class="col" style="font-weight:bold;text-align: center ; vertical-align: middle;">대기 정보 입력</div>
                    <div class="row">
                        <div class="col" style="font-weight:bold;vertical-align: middle;padding-bottom: 20px;">
                            1.대기 번호 안내를 받을 전화번호를 입력하여 주시기 바라니다.<BR>
                            2.판매장에서 호출되는 대기 번호 확인 후 구매상품을 선택하시면 됩니다.<BR>
                            3.구매 완료 및 계산 후 문자로 받으신 수령번호를 숙지 하시어 방혈 작업이 완료된 후 상품을 수령하시면 됩니다.<BR>
                        </div>
                    </div>
                    <div class="row">
                        <form method="post" action="/waitreg/setwait" id="frm" name="frm">
                            <input type="hidden" name="rtype" id="rtype" value="">
                            <div class="form-group row" style="border-top: solid #9d9d9d 1px; padding-bottom: 5px;padding-top: 5px">
                                <label class="col-sm-3 col-form-label">전화번호</label>
                                <div class="col-sm-9">
                                    <input type="telnum" class="form-control form-control-sm" name="callNum" id="callNum" value="" autocomplete="off" placeholder="010-1234-1234"  />
                                </div>
                            </div>

                            <div class="form-group row" style="border-top: solid #9d9d9d 1px; padding-bottom: 5px;padding-top: 5px">
                                <label class="col-sm-3 col-form-label">인증번호</label>
                                <div class="col-sm-9">
                                    <input type="telnum" class="form-control form-control-sm" name="authNum" id="authNum" value="" autocomplete="off" placeholder="인증번호4자리" /><p>
                                    <a  href="#" class="btn-primary text-center btn" onclick="setAuth()">인증 번호 요청</a>
                                </div>
                            </div>

                            <div class="row" style="border-top: solid #9d9d9d 1px; padding-bottom: 10px;padding-top: 10px">
                                <label class="col-sm-3">만료 시간</label>
                                <div class="col-sm-9" id="remainTime">00분00초</div>
                            </div>

                            <div class="row">
                                <a  href="#" class="form-control btn-danger" class="btn" onclick="frmsubmit('01')">업체 대기 등록</a><p></p>
                                <a  href="#" class="form-control btn-success" class="btn" onclick="frmsubmit('02')">노도시 예약자 대기 등록</a><p></p>
                                <a  href="#" class="form-control btn-secondary" class="btn" onclick="frmsubmit('03')">일반 대기 등록</a>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

</script>