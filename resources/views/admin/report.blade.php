<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="{{ asset('styles.css') }}" />
    <script src="{{ asset('./assets/js/jquery-3.5.1.js')}}"></script>

    <script src="{{ asset('scripts.js')}}" defer></script>
    <!-- sweetalert -->
    <script src="{{ asset('./sweetalert/sweetalert.min.js')}}" defer></script>

    <!-- chartjs -->
    <script src="{{ asset('chartjs/package/dist/chart.js')}}"></script>
    <script src="{{ asset('chartjs/datalabels.min.js')}}"></script>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 p-5">
                <h1>TANAW Report</h1>
                <P>As of {{now()->format('M d Y')}}</P>
                <hr>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="d-flex justify-content-between align-items-end">
                            <h5>TOTAL NO. OF PAYMENTS</h5>
                            <h2>{{$data['payments']}}</h2>
                        </div>
                        <div class="d-flex justify-content-between align-items-end">
                            <h5>TOTAL NO. OF VISTORS</h5>
                            <h2>{{$data['visitors']}}</h2>
                        </div>
                        <div class="d-flex justify-content-between align-items-end">
                            <h5>OVERALL REVENUE</h5>
                            <h2>&#8369; {{$data['revenue']}}.00 </h2>
                        </div>
                        <div class="d-flex justify-content-between align-items-end">
                            <h5>TOTAL NO. OF TRANSACIONS MADE</h5>
                            <h2>{{$data['transactions']}}</h2>
                        </div>
                        <div class="d-flex justify-content-between align-items-end">
                            <h5>TOTAL NO. OF USERS</h5>
                            <h2>{{$data['user']}}</h2>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <P>Transactions</P>
                        <table class="table table-striped" style="font-size: 11px" id="table-recent">
                            <thead class="text-white bg-primary">
                                <th>No. Transaction</th>
                                <th>Revenue</th>
                                <th>Date</th>
                            </thead>
                            <tbody>
                                @foreach($table_data as $dt)
                                <td class="text-dark">{{$dt->payment_count}}</td>
                                <td class="text-dark">&#8369; {{$dt->total}} </td>
                                <td class="text-dark">{{$dt->date}}</td>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <hr>
                <p>Graphs</p>
                <div class="row">
                    <div class="col-sm-8 col-md-8 col-lg-8 mb-2">
                        <div class=" border rounded p-2">
                            <h1 class="fs-6 mb-2">Revenue</h1>
                            <div class="d-flex">
                                <span class="btn-overview overview-active" id="btn-weekly">Weekly</span>
                                <span class="btn-overview" id="btn-monthly">Monthly</span>
                                <span class="btn-overview" id="btn-annually">Annually</span>
                            </div>
                            <div id="overview-div">
                                <canvas id="overviewChart" height="40%" width="100%"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4 col-md-4 col-lg-4 mb-2">
                        <div class=" border rounded p-2">
                            <h1 class="fs-6 mb-2">Ratings</h1>

                            <div id="rating-div">
                                <canvas id="ratingchart" height="92%" width="100%"></canvas>
                            </div>
                        </div>
                    </div>


                    <div class="col-sm-6 col-md-6 col-lg-6 mb-2">
                        <div class=" border rounded p-2">
                            <h1 class="fs-6 mb-2">Visitors</h1>
                            <div class="d-flex">
                                <span class="btn-overview overview-active" id="btn-weekly-v">Per week</span>
                                <span class="btn-overview" id="btn-monthly-v">Per month</span>
                                <span class="btn-overview" id="btn-annually-v">All time</span>
                            </div>
                            <div id="overview-div-v">
                                <canvas id="overviewChart_visitor" height="50%" width="100%"></canvas>
                            </div>
                        </div>
                    </div>


                    <div class="col-sm-6 col-md-6 col-lg-6 mb-2">
                        <div class=" border rounded p-2">
                            <h1 class="fs-6 mb-2">Entrance payments</h1>
                            <div class="d-flex">
                                <span class="btn-overview overview-active" id="btn-weekly-e">Per week</span>
                                <span class="btn-overview" id="btn-monthly-e">Per month</span>
                                <span class="btn-overview" id="btn-annually-e">All time</span>
                            </div>
                            <div id="overview-div-e">
                                <canvas id="overviewChart_entrance" height="50%" width="100%"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    function load_overview_chart(chart_data) {

        var revenue_labels = [];
        var revenue_points = []

        for (let i = 0; i < chart_data.length; i++) {
            revenue_labels.push(chart_data[i].date)
            revenue_points.push(chart_data[i].total)

        }
        var ctx_o = document.getElementById('overviewChart')
        var chart_o = new Chart(ctx_o, {
            type: 'line',
            data: {
                labels: revenue_labels,
                datasets: [{
                    label: ['Revenue'],
                    data: revenue_points,
                    backgroundColor: [
                        'springgreen',
                    ],
                    borderColor: [
                        'springgreen'

                    ],
                    borderWidth: 1,
                    fill: true
                }]
            },

            plugins: [ChartDataLabels],
            options: {
                bezierCurve: true,
                elements: {
                    line: {
                        tension: 0.5
                    }
                },

                scales: {
                    y: {
                        ticks: {
                            color: 'black'
                        },
                        display: true,
                        title: {
                            display: true,
                            text: 'Revenue amount'
                        },
                        grid: {
                            color: 'gray'
                        }
                    },
                    x: {
                        ticks: {
                            color: 'black'
                        }
                    }

                },
                responsive: true,
                plugins: {
                    datalabels: {
                        display: true,
                        formatter: (value, ctx) => {
                            return "\u20B1 " + parseFloat(ctx.chart.data.datasets[0].data[ctx.dataIndex]).toFixed(2)
                        },
                        backgroundColor: 'crimson',
                        color: 'white',
                        borderRadius: 3,
                        font: {
                            size: 8
                        }
                    }
                }
            }
        })
    }

    function overview_data(category) {

        var temp_uri = "{{ route('overview.get', ':category') }}";
        $.ajax({
            url: temp_uri.replace(':category', category),
            type: 'get',
            dataType: 'json',
            beforeSend: function() {}
        }).done(function(data) {
            if (data.status == 200) {
                load_overview_chart(data.data)
            }
        }).fail(function(e) {

        })
    }

    overview_data(7)

    $('#btn-weekly').on('click', function(e) {
        e.preventDefault()
        $('#btn-weekly').addClass('overview-active')
        $('#btn-annually').removeClass('overview-active')
        $('#btn-monthly').removeClass('overview-active')
        $('#overviewChart').remove();
        $('#overview-div').html('<canvas id="overviewChart" height="50%" width="100%"></canvas>')
        overview_data(7)
    })

    $('#btn-monthly').on('click', function(e) {
        e.preventDefault()
        $('#btn-weekly').removeClass('overview-active')
        $('#btn-annually').removeClass('overview-active')
        $('#btn-monthly').addClass('overview-active')
        $('#overviewChart').remove();
        $('#overview-div').html('<canvas id="overviewChart" height="50%" width="100%"></canvas>')
        overview_data(30)
    })

    $('#btn-annually').on('click', function(e) {
        e.preventDefault()
        $('#btn-weekly').removeClass('overview-active')
        $('#btn-annually').addClass('overview-active')
        $('#btn-monthly').removeClass('overview-active')
        $('#overviewChart').remove();
        $('#overview-div').html('<canvas id="overviewChart" height="50%" width="100%"></canvas>')
        overview_data(365)
    })



    //ratings
    function load_Ratings(excellent, great, good, poor, terrible) {


        var ctx_r = document.getElementById('ratingchart')
        var chart_r = new Chart(ctx_r, {
            type: 'bar',
            data: {
                labels: ['excellent', 'great', 'good', 'poor', 'terrible'],
                datasets: [{
                    label: ['Rating'],
                    data: [excellent, great, good, poor, terrible],
                    backgroundColor: [
                        'orange',
                        'dodgerblue',
                        'springgreen',
                        'crimson',
                        'red',
                    ],
                    borderColor: [
                        'orange',
                        'dodgerblue',
                        'springgreen',
                        'crimson',
                        'red',

                    ],
                    borderWidth: 1,
                    fill: true,
                }]
            },

            plugins: [ChartDataLabels],
            options: {
                scales: {
                    y: {
                        ticks: {
                            color: 'black'
                        },
                        display: true,
                        title: {
                            display: true,
                            text: 'Ratings'
                        },
                        grid: {
                            color: 'gray'
                        }
                    },
                    x: {
                        ticks: {
                            color: 'black'
                        }
                    }

                },
                responsive: true,
                plugins: {
                    datalabels: {
                        display: true,
                        backgroundColor: 'crimson',
                        color: 'white',
                        borderRadius: 3,
                        font: {
                            size: 8
                        }
                    }
                }
            }
        })
    }

    function load_Ratings_Data() {

        var temp_uri = "{{ route('ratings.get') }}";
        $.ajax({
            url: temp_uri,
            type: 'get',
            dataType: 'json',
            beforeSend: function() {}
        }).done(function(data) {
            if (data.status == 200) {
                console.log(data)
                load_Ratings(data.data.excellent, data.data.great, data.data.good, data.data.poor, data.data.terrible)
            }
        }).fail(function(e) {

        })
    }

    load_Ratings_Data()

    /**
     * visitor chart
     */

    function load_overview_chart_visitor(chart_data) {

        var revenue_labels_v = [];
        var revenue_points_v = []

        for (let i = 0; i < chart_data.length; i++) {
            revenue_labels_v.push(chart_data[i].date)
            revenue_points_v.push(chart_data[i].total)

        }
        var ctx_v = document.getElementById('overviewChart_visitor')
        var chart_v = new Chart(ctx_v, {
            type: 'line',
            data: {
                labels: revenue_labels_v,
                datasets: [{
                    label: ['No. of visitor'],
                    data: revenue_points_v,
                    backgroundColor: [
                        'crimson',
                    ],
                    borderColor: [
                        'crimson'

                    ],
                    borderWidth: 1,
                    fill: true
                }]
            },

            plugins: [ChartDataLabels],
            options: {
                scales: {
                    y: {
                        ticks: {
                            color: 'black'
                        },
                        display: true,
                        title: {
                            display: true,
                            text: 'Revenue amount'
                        },
                        grid: {
                            color: 'gray'
                        }
                    },
                    x: {
                        ticks: {
                            color: 'black'
                        }
                    }

                },
                responsive: true,
                plugins: {
                    datalabels: {
                        display: true,
                        backgroundColor: 'crimson',
                        color: 'white',
                        borderRadius: 3,
                        font: {
                            size: 8
                        }
                    }
                }
            }
        })
    }

    function overview_data_visitor(category) {

        var temp_uri = "{{ route('overview.visitor', ':category') }}";
        $.ajax({
            url: temp_uri.replace(':category', category),
            type: 'get',
            dataType: 'json',
            beforeSend: function() {}
        }).done(function(data) {
            if (data.status == 200) {
                load_overview_chart_visitor(data.data)
                console.log(data)
            }
        }).fail(function(e) {

        })
    }

    overview_data_visitor(7)

    $('#btn-weekly-v').on('click', function(e) {
        e.preventDefault()
        $('#btn-weekly-v').addClass('overview-active')
        $('#btn-annually-v').removeClass('overview-active')
        $('#btn-monthly-v').removeClass('overview-active')
        $('#overviewChart_visitor').remove();
        $('#overview-div-v').html('<canvas id="overviewChart_visitor" height="50%" width="100%"></canvas>')
        overview_data_visitor(7)
    })

    $('#btn-monthly-v').on('click', function(e) {
        e.preventDefault()
        $('#btn-weekly-v').removeClass('overview-active')
        $('#btn-annually-v').removeClass('overview-active')
        $('#btn-monthly-v').addClass('overview-active')
        $('#overviewChart_visitor').remove();
        $('#overview-div-v').html('<canvas id="overviewChart_visitor" height="50%" width="100%"></canvas>')
        overview_data_visitor(30)
    })

    $('#btn-annually-v').on('click', function(e) {
        e.preventDefault()
        $('#btn-weekly-v').removeClass('overview-active')
        $('#btn-annually-v').addClass('overview-active')
        $('#btn-monthly-v').removeClass('overview-active')
        $('#overviewChart_visitor').remove();
        $('#overview-div-v').html('<canvas id="overviewChart_visitor" height="50%" width="100%"></canvas>')
        overview_data_visitor(365)
    })

    /**
     * @ entrance payments
     */

    function load_overview_chart_entrance(chart_data) {

        var revenue_labels_e = [];
        var revenue_points_e = []

        for (let i = 0; i < chart_data.length; i++) {
            revenue_labels_e.push(chart_data[i].date)
            revenue_points_e.push(chart_data[i].total)

        }
        var ctx_e = document.getElementById('overviewChart_entrance')
        var chart_e = new Chart(ctx_e, {
            type: 'line',
            data: {
                labels: revenue_labels_e,
                datasets: [{
                    label: ['Entrance amount'],
                    data: revenue_points_e,
                    backgroundColor: [
                        'orange',
                    ],
                    borderColor: [
                        'orange'

                    ],
                    borderWidth: 1,
                    fill: true,
                }]
            },

            plugins: [ChartDataLabels],
            options: {
                scales: {
                    y: {
                        ticks: {
                            color: 'white'
                        },
                        display: true,
                        title: {
                            display: true,
                            text: 'Entrances amount'
                        },
                        grid: {
                            color: 'gray'
                        }
                    },
                    x: {
                        ticks: {
                            color: 'white'
                        }
                    }

                },
                responsive: true,
                plugins: {
                    datalabels: {
                        display: true,
                        backgroundColor: 'crimson',
                        color: 'white',
                        borderRadius: 3,
                        font: {
                            size: 8
                        }
                    }
                }
            }
        })
    }

    function overview_data_entrance(category) {

        var temp_uri = "{{ route('overview.entrance', ':category') }}";
        $.ajax({
            url: temp_uri.replace(':category', category),
            type: 'get',
            dataType: 'json',
            beforeSend: function() {}
        }).done(function(data) {
            if (data.status == 200) {
                load_overview_chart_entrance(data.data)
                console.log(data)
            }
        }).fail(function(e) {

        })
    }

    overview_data_entrance(7)

    $('#btn-weekly-e').on('click', function(e) {
        e.preventDefault()
        $('#btn-weekly-e').addClass('overview-active')
        $('#btn-annually-e').removeClass('overview-active')
        $('#btn-monthly-e').removeClass('overview-active')
        $('#overviewChart_entrance').remove();
        $('#overview-div-e').html('<canvas id="overviewChart_entrance" height="50%" width="100%"></canvas>')
        overview_data_entrance(7)
    })

    $('#btn-monthly-e').on('click', function(e) {
        e.preventDefault()
        $('#btn-weekly-e').removeClass('overview-active')
        $('#btn-annually-e').removeClass('overview-active')
        $('#btn-monthly-e').addClass('overview-active')
        $('#overviewChart_entrance').remove();
        $('#overview-div-e').html('<canvas id="overviewChart_entrance" height="50%" width="100%"></canvas>')
        overview_data_entrance(30)
    })

    $('#btn-annually-e').on('click', function(e) {
        e.preventDefault()
        $('#btn-weekly-e').removeClass('overview-active')
        $('#btn-annually-e').addClass('overview-active')
        $('#btn-monthly-e').removeClass('overview-active')
        $('#overviewChart_entrance').remove();
        $('#overview-div-e').html('<canvas id="overviewChart_entrance" height="50%" width="100%"></canvas>')
        overview_data_entrance(365)
    })

    window.print()
</script>

</html>