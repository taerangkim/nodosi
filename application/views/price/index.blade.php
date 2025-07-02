<style>
    .modal
    {
        overflow: scroll !important;
    }
</style>
    <p></p>
    <div class="row bg-light pt-1">
        <div class="col">
            해당 시세는 한길통상 판매가 기준 시세 입니다.
        </div>
    </div>
    <hr class="sidebar-divider d-none d-md-block">
    @foreach($result as $item)
    <div class="row bg-light">
        <div class="col">
            @if ($loop->first)
                <h5>{{$item['RegDatm']}} 시세 정보</h5>
                @foreach($todayPrice as $itemPrice)
                    <div class="Row pt-2 pb-2">
                        <a href="javascript:;" onclick="loadMarketPrice({{$itemPrice['ProdCode']}},{{$itemPrice['OrgCode']}},{{$itemPrice['KgCode']}},this)">{{$itemPrice['FishName']}} /
                        {{$itemPrice['ProdName']}} /
                        {{$itemPrice['OrgName']}} /
                        {{$itemPrice['KgName']}} : {{$itemPrice['MarketPrice']}}원</a>
                    </div>
                @endforeach
            @else
                <hr class="sidebar-divider d-none d-md-block">
                <div class="row pt-2" id="date_{{$item['RegDatm']}}">
                    <a href="javascript:;" onclick="loadMarketPriceDate('{{$item['RegDatm']}}')" class="text-dark">{{$item['RegDatm']}} 시세 정보 [ <span class="text-primary">자세히 보기</span> ]</a>
                </div>
            @endif
        </div>
    </div>
    @endforeach
    <script>
        function loadMarketPriceDate(loadDate)
        {
            $("#markPriceDate").text(loadDate + '시세 정보');
            $("#marketPriceBody").empty();
            gfn_ajaxpost(
                '/price/loadPriceDate',
                {date :  loadDate},
                function (data) {
                    $.each(data, function (index, item){
                        html = '<div class="row pt-1 pb-1"><a href="javascript:;" onclick="loadMarketPrice('
                            + item['ProdCode']
                            + ',' + item['OrgCode'] + ',' +  item['KgCode'] + ',this)">' +
                            item['FishName'] + ' / ' +
                            item['ProdName'] + ' / ' +
                            item['OrgName'] + ' / ' +
                            item['KgName'] + ' : ' +
                            item['MarketPrice'] + '원</div>';
                        $("#marketPriceBody").append(html);
                    });
                    $("#marketPriceModal").modal('show');
                });
        }
        var ChartObj;
        function loadMarketPrice(pCode, oCode, kCode, obj)
        {
            $("#markPriceTitle").text($(obj).text());
            console.log(typeof(ChartObj));
            if(typeof(ChartObj)=='object')
            {
                ChartObj.clear();
                ChartObj.destroy();
            }

            gfn_ajaxpost(
                '/price/loadPriceData',
                {prodCode :  pCode,  orgCode : oCode, kgCode : kCode},
                function (data) {
                    var RegDatm = new Array();
                    var price = new Array();
                    $.each(data, function (index, item){
                        RegDatm.push(item["RegDatm"]);
                        price.push(item["Price"]);
                    })
                    $("#myChart").empty();


                    var ctx = document.getElementById("myChart");

                    ChartObj = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: RegDatm,
                            datasets: [{
                                data: price,
                                lineTension: 0,
                                backgroundColor: 'transparent',
                                borderColor: '#007bff',
                                borderWidth: 1,
                                pointBackgroundColor: '#007bff'
                            }]
                        },
                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true
                                    }
                                }]
                            },
                            legend: {
                                display: false,
                            }
                        }
                    });
                    ChartObj.update();

                });
            $("#priceModal").modal('show');
        }
        function closePrice()
        {

            $("#priceModal").modal('hide');
        }
        function closeMarketPrice()
        {
            $("#marketPriceModal").modal('hide');
        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>

    <div class="modal" id="marketPriceModal" tabindex="-100" role="dialog" aria-hidden="true" backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="markPriceDate"></h6>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col" id="marketPriceBody"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeMarketPrice();">닫기</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="priceModal" tabindex="-1" role="dialog" aria-hidden="true" backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="markPriceTitle"></h6>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col"><canvas class="my-4" id="myChart" class="h-100"></canvas></div>
                    </div>
                    <div class="row">
                        <div class="col">0원은 경매가 없거나 시세 데이터가 없는경우 입니다.</div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closePrice();">닫기</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-Y64CM9FHE2"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-Y64CM9FHE2');
</script>