<div class="row bg-light pt-3">
    <div class="card cardcolor1">
        <div class="card-body">
            <div class="card-title" style="font-size: small  ">
                <div class="row">
                    <div class="col" style="font-weight:bold;text-align: center ; vertical-align: middle;">수령 정보 입력</div>
                    <div class="row">
                        <div class="col" style="font-weight:bold;vertical-align: middle;padding-bottom: 20px;">
                            1.수령 번호는 판매자가 불러주는 번호를 입력하시면 됩니다.<BR>
                            2.계산이 완료 된 후 해당 수령 번호가 부착된 물건을 수령하시면 됩니다.<BR>
                        </div>
                    </div>
                    <div class="row">
                        <form method="post" action="/wait/setSaleNum" id="frm" name="frm">
                            <input type="hidden" name="WaitIdx" id="WaitIdx" value="{{$wait}}">
                            <div class="form-group row" style="border-top: solid #9d9d9d 1px; padding-bottom: 5px;padding-top: 5px">
                                <label class="col-sm-3 col-form-label">수령번호</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control form-control-sm" name="receiptNum" id="receiptNum" value="" autocomplete="off" placeholder="숫자 형식만 입력가능" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');" telOnly="true"/>
                                </div>
                            </div>
                            <div class="row">
                                    <button type="button" class="form-control btn-success" class="btn" onclick="frmsubmit()">수령번호 등록하기</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function frmsubmit()
    {
        if ($("#receiptNum") == '')
        {
            alert("수령번호를 입력하여 주시기 바랍니다.");
            return;
        }
        $("#frm").submit();


    }
</script>