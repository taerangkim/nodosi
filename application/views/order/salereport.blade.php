
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="theme-color" content="#7952b3">
    <meta property="og:image" content="http://nodosi.co.kr/img/fav/favicon-16x16.png">
    <title>노도시</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link href="/css/bootstrap.css" rel="stylesheet" crossorigin="anonymous">

    <link rel="stylesheet" href="/css/blueimp-gallery.css">
    <script type="text/javascript" src="/js/function.js"></script>
    <script type="text/javascript" src="/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/js/jquery-3.5.1.js"></script>
    <script src="https://kit.fontawesome.com/f7cacd7fe0.js" crossorigin="anonymous"></script>
    <script tpye="text/javascript" src="/js/function.js"></script>

    <script type="text/javascript" src="/js/blueimp-gallery.js"></script>
    <script type="text/javascript" src="/js/jquery.blueimp-gallery.js"></script>
    <script tpye="text/javascript" src="/js/html2canvas.min.js"></script>
</head>
<style>
    body{ background-color: #F7FFF5;}

    img.fixed  {
        position: fixed;
        left: 100px;
        top: 50px;
        min-width: auto;
    }
</style>

<link rel="stylesheet" href="/css/jquery-ui.css?cache=<?=date('Ymdmsi')?>">
<script src="/js/jquery-ui.js"></script>
<script>
    $( window ).resize( function() {
        $("#stamp").css("left",$("#s").offset().left +20);
    } );
    window.onload = function(){
        $("#stamp").css("left",$("#s").offset().left +20);
    }
    function savleimg()
    {
        html2canvas(document.querySelector("#capture")).then(canvas => {
            document.body.appendChild(canvas);
            var el = document.getElementById("target");
            el.href = canvas.toDataURL("image/jpeg");
            el.download = '{{date("Y년m월d일", strtotime($mainResult[0]['RegDate']))}}_거래명세표.jpg';
            el.click();
        });
    }

</script>
<body id="page-top"  style="font-size: small">
<div id="capture" style="padding: 10px; background: #f5da55">
    <div id="wrapper">
        <img id="stamp" src="/img/nodosistamp3.png" style="max-width:100%; height:auto;position: absolute;top:100px;left:350px;">
        <table class="table table-bordered" style="border-color: black">
            <tr>
                <td colspan="4" style="text-align: center">{{date("Y년m월d일", strtotime($mainResult[0]['RegDate']))}} 거래명세표</td>
            </tr>
            <tr>
                <td colspan="4">공급자</td>
            </tr>
            <tr>
                <td>등록번호</td>
                <td colspan="3">970-86-02202 </td>
            </tr>
            <tr>
                <td>상호</td>
                <td>(주)노도시</td>
                <td>성명</td>
                <td><span id="s" style="position: absolute;">송준호</span></td>
            </tr>
            <tr>
                <td>주소</td>
                <td colspan="3">인천시 서구 연희로6, 지하1</td>
            </tr>
            <tr>
                <td>업태</td>
                <td>도소매</td>
                <td>종목</td>
                <td>수산물</td>
            </tr>
            <tr>
                <td colspan="4">공급받는자</td>
            </tr>
            <tr>
                <td>상호</td>
                <td colspan="3">{{$orderName}} 님</td>
            </tr>
        </table>
        <table class="table table-bordered table-striped table-sm" style="border-color: black">
            <tr>
                <th>품목</th>
                <th>규격</th>
                <th>무게</th>
                <th>단가</th>
                <th>공급가액</th>
                <th>비고</th>
            </tr>
            @php
                $count =0;
            @endphp
            @foreach($subResult as $item)
                <tr>
                    <td>{{$item['OrgName']}} / {{$item['ProdName']}}  / {{$item['FishName']}}</td>
                    <td>{{$item['Unit']}}</td>
                    <td>{{$item['Weight']}}</td>
                    <td>{{number_format($item['UnitPrice'])}}원</td>
                    <td>{{number_format($item['ProdPrice'])}}원</td>
                </tr>
                @php
                    $count++;
                @endphp
            @endforeach
            @if ($count < 10)
                @for ($i = $count; $i < 10; $i++)
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                @endfor
            @endif
            @php
                $totalPrice = $mainResult[0]['CashPrice'] + $mainResult[0]['BankPrice'] + $mainResult[0]['ResevePrice'];
            @endphp
        </table>
        <table class="table table-bordered table-striped table-sm" style="border-color: black">
            <tr>
                <td>할인</td>
                <td>{{number_format($mainResult[0]['DiscountPrice'])}} 원</td>
                <td>입금</td>
                <td>{{number_format($totalPrice)}} 원</td>
                <td>잔금</td>
                <td>{{number_format($mainResult[0]['CreditPrice'])}}원</td>
            </tr>
        </table>
    </div>
</div>
<div class="row">
    <input type="button" value="명세표 다운로드 받기" class="btn btn-dark btn-block" onclick="savleimg()"/>
<!--
    <button class="btn btn-block btn-dark" class="download"> 명세표 다운로드 받기</button>
    -->
</div>
<a id="target"></a>
</body>


