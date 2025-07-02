<div class="container" style="min-height:600px;">
    @include('_templates.myheader')
    <div class="container" style="background-color: #e0e0e0;padding-top: 10px">
        <div class="card cardcolor1">
            <div class="card-body">
                <div class="card-title" style="font-size: small  ">
                    <div class="row">
                        <div class="col col-4" style="font-weight:bold;text-align: center">
                            <img src="/img/fish/광어.jpg"  class="w-100"><p></p>
                            광어 (자연산)<p></p>
                            관련 딜 현재 N 개
                        </div>
                        <div class="col col-8"><canvas class="my-4" id="myChart" class="h-100"></canvas></div>
                    </div>
                    <div class="row">
                        <div class="col col-4">
                            <button type="submit" class="form-control" class="btn" style="font-size: x-small" onclick="document.location.href='deal/makedealstep1'">
                                <i class="fas fas fa-people-arrows fa-w-16 fa-lg icon"></i>
                                딜 생성</button>
                        </div>
                        <div class="col col-4">
                            <button type="submit" class="form-control" class="btn" style="font-size: x-small">
                                <i class="fas fa-search fa-w-16 fa-lg"   style="color:#0A5EE1"></i>
                                관련 딜 검색</button>
                        </div>
                        <div class="col col-4">
                            <button type="submit" class="form-control" class="btn" style="font-size: x-small">
                                <i class="fas fa-ban fa-w-16 fa-lg" style="color:#ff0000"></i>
                                관심어종 삭제</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card cardcolor1">
            <div class="card-body">
                <div class="card-title" style="font-size: small  ">
                    <div class="row">
                        <div class="col col-4" style="font-weight:bold;text-align: center">
                            <img src="/img/fish/광어.jpg"  class="w-100"><p></p>
                            광어 (자연산)<p></p>
                            관련 딜 현재 N 개
                        </div>
                        <div class="col col-8"><canvas class="my-4" id="myChart1" class="h-100"></canvas></div>
                    </div>
                    <div class="row">
                        <div class="col col-4">
                            <button type="submit" class="form-control" class="btn" style="font-size: x-small" onclick="document.location.href='deal/makedealstep1'">
                                <i class="fas fas fa-people-arrows fa-w-16 fa-lg icon"></i>
                                딜 생성</button>
                        </div>
                        <div class="col col-4">
                            <button type="submit" class="form-control" class="btn" style="font-size: x-small">
                                <i class="fas fa-search fa-w-16 fa-lg"   style="color:#0A5EE1"></i>
                                관련 딜 검색</button>
                        </div>
                        <div class="col col-4">
                            <button type="submit" class="form-control" class="btn" style="font-size: x-small">
                                <i class="fas fa-ban fa-w-16 fa-lg" style="color:#ff0000"></i>
                                관심어종 삭제</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card cardcolor1">
            <div class="card-body">
                <div class="card-title" style="font-size: small  ">
                    <div class="row">
                        <div class="col col-4" style="font-weight:bold;text-align: center">
                            <img src="/img/fish/광어.jpg"  class="w-100"><p></p>
                            광어 (자연산)<p></p>
                            관련 딜 현재 N 개
                        </div>
                        <div class="col col-8"><canvas class="my-4" id="myChart2" class="h-100"></canvas></div>
                    </div>
                    <div class="row">
                        <div class="col col-4">
                            <button type="submit" class="form-control" class="btn" style="font-size: x-small" onclick="document.location.href='deal/makedealstep1'">
                                <i class="fas fas fa-people-arrows fa-w-16 fa-lg icon"></i>
                                딜 생성</button>
                        </div>
                        <div class="col col-4">
                            <button type="submit" class="form-control" class="btn" style="font-size: x-small">
                                <i class="fas fa-search fa-w-16 fa-lg"   style="color:#0A5EE1"></i>
                                관련 딜 검색</button>
                        </div>
                        <div class="col col-4">
                            <button type="submit" class="form-control" class="btn" style="font-size: x-small">
                                <i class="fas fa-ban fa-w-16 fa-lg" style="color:#ff0000"></i>
                                관심어종 삭제</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
<script>
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
                pointBackgroundColor: '#007bff'
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

    var ctx1 = document.getElementById("myChart1");
    var myChart = new Chart(ctx1, {
        type: 'line',
        data: {
            labels: ["월", "화", "수", "목", "금", "토", "일"],
            datasets: [{
                data: [15339, 21345, 18483, 24003, 23489, 24092, 12034],
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
                        beginAtZero: false
                    }
                }]
            },
            legend: {
                display: false,
            }
        }
    });
    var ctx2 = document.getElementById("myChart2");
    var myChart = new Chart(ctx2, {
        type: 'line',
        data: {
            labels: ["월", "화", "수", "목", "금", "토", "일"],
            datasets: [{
                data: [15339, 21345, 18483, 24003, 23489, 24092, 12034],
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

