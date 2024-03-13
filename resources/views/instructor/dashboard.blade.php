@extends('layout.main-side')

@section('content')
<title>{{$name}} - Dashboard</title>
<div class="sidetoppadding">
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-secondary shadow h-100 py-2 px-4">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                Number of Courses</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$totalCourses}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-book fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2 px-4">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Earnings</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$totalEarningsFormatted}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-peso-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2 px-4">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total Students</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$totalStudents}}</div>
                        </div>
                        <div class="col-auto">

                            <i class="fas fa-user-graduate fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2 px-4">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Student Reviews</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{count($reviews)}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2 px-4">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Total Sales</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chart-column fa-2x text-gray-300"></i>
                        </div>

                        <div class="chart-container">
                            <div>
                                <canvas id="myChart" height="350"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2 px-4">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Earnings</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-arrow-trend-up fa-2x text-gray-300"></i>
                        </div>

                        <div class="chart-container">
                            <div>
                                <canvas id="myLineChart" height="350"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
<script>
    const ctx = document.getElementById('myChart');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($courseTitles),
            datasets: [{
                label: 'Course Sales',
                backgroundColor: "rgba(255,99,132,0.2)",
                borderColor: "rgba(255,99,132,1)",
                borderWidth: 2,
                hoverBackgroundColor: "rgba(255,99,132,0.4)",
                hoverBorderColor: "rgba(255,99,132,1)",
                data: @json($courseCounts),
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    stacked: true,
                    display: false,
                    grid: {
                        display: true,
                        color: "rgba(255,99,132,0.2)"
                    }
                },
                x: {
                    grid: {
                        display: true,
                        color: "rgba(255,99,132,0.2)"
                    }
                }
            }
        }
    });
</script>
<script>
    const ctx2 = document.getElementById('myLineChart');
    const labels = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    const data = {
        labels: labels,
        datasets: [{
                label: 'Sales',
                data: @json($earnings),
                fill: false,
                borderColor: 'rgb(0, 123, 225)',
                tension: 0.1,
                yAxisID: 'y',
            },
            {
                label: 'Withdrawals',
                data: @json($withdrawals),
                fill: false,
                borderColor: 'rgb(40, 160, 0)',
                tension: 0.1,
                yAxisID: 'y',
            }
        ]
    };
    new Chart(ctx2, {
        type: 'line',
        data: data,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    ticks: {
                        // Include a dollar sign in the ticks
                        callback: function(value, index, ticks) {
                            return '₱' + value;
                        }
                    }
                }
            }
        }

    });
</script>
@endsection