<div class="container" style="background-color: #e0e0e0;padding-top: 10px">
    <div class="row">
        <div class="col col-9">
            <input type="text" class="form-control" id="inputPassword2" placeholder="검색">
        </div>
        <div class="col col-3">
            <button type="submit" class="form-control" class="btn">검색</button>
        </div>
    </div>
    <p></p>
    <div class="row">
        <div class="col" id="slideItem" style="padding-left: 20px">
            내 관심 어종 => 광어 1k 당 10,000, 우럭 1k 당 5,000
        </div>
    </div>
</div>
<div class="container w-100" style="background-color: #e0e0e0;">
    <div class="row">
        <div class="col"><p style="border: solid #539CCF 2px; padding: 10px; background-color: #539CCF;color: #ffffff; font-weight: bold;font-size: medium">광어 시세</p></div>
    </div>
</div>

<div class="container" style="background-color: #e0e0e0;">
    <div class="card cardcolor1">
        <div class="card-body">
            <div class="card-text" >
                <div class="col col-12"><canvas id="myChart" width="500" height="200"></canvas></div>
            </div>
        </div>
    </div>
</div>
<div class="container w-100" style="background-color: #e0e0e0;">
    <div class="row">
        <div class="col"><p style="border: solid #539CCF 2px; padding: 10px; background-color: #539CCF;color: #ffffff; font-weight: bold;font-size: medium">지금 핫딜</p></div>
    </div>

</div>
@include('deal.deal')
<div class="container w-100" style="background-color: #e0e0e0;padding-top: 10px">
    <button type="submit" class="form-control" class="btn" style="font-size: small">진행 중인 딜 더보기</button>
</div>
<div class="container w-100" style="background-color: #e0e0e0;">
    <div class="row">
        <div class="col"><p style="border: solid #539CCF 2px; padding: 10px; background-color: #539CCF;color: #ffffff; font-weight: bold;font-size: medium">후기</p></div>
    </div>
</div>
@include('review.review')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
<script>
    //$('#slideItem').animate({left: 0}, 1000);
    var ctx = document.getElementById("myChart");
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ["월", "화", "수", "목", "금", "토", "일"],
            datasets: [{
                data: [15339, 21345, 18483, 24003, 23489, 24092, 12034],
                lineTension: 0,
                backgroundColor: 'transparent',
                borderColor: '#007bff',
                borderWidth: 1,
                pointBackgroundColor: '#007bff',
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: false
                    }
                }]
            },
            legend: {
                display: false,
            }
        }
    });
</script>

