@extends('layout.main-side')

@section('content')
<title>Admin - Dashboard</title>

<div class="sidetoppadding">
    <div class="row">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2 px-4">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Number of Courses</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"> {{$allCourses}} </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-book fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2 px-4">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Total Number of Instructors</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"> {{$allInstructors}} </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chalkboard-teacher fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2 px-4">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Number of Students</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"> {{$allStudents}} </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-graduate fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div class="card border-left-info shadow h-100 py-2 px-4">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Sales</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-arrow-trend-up fa-2x text-gray-300"></i>
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
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
<script>
    const ctx = document.getElementById('myChart');
    const labels = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    const data = {
        labels: labels,
        datasets: [{
                label: 'Total Sales',
                data: @json($amounts),
                fill: false,
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1,
                yAxisID: 'y',
            },
            {
                label: 'Instructors Earnings',
                data: @json($instructorAmount),
                fill: false,
                borderColor: 'rgb(255, 71, 71)',
                tension: 0.1,
                yAxisID: 'y',
            },
            {
                label: 'Total Earnings',
                data: @json($adminAmount),
                fill: false,
                borderColor: 'rgb(71, 164, 255)',
                tension: 0.1,
                yAxisID: 'y',
            }
        ]
    };
    new Chart(ctx, {
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