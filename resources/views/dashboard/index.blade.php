@extends('layouts.app')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header content-header{{ 1 }}">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-bold">{{ trans('lang.dashboard') }}
                        <small class="mx-3">|</small>
                        <small>{{ trans('lang.dashboard_overview') }}</small>
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb bg-white float-sm-right rounded-pill px-4 py-2 d-none d-md-flex">
                        <li class="breadcrumb-item">
                            <a href="#">
                                <i class="fas fa-tachometer-alt"></i>
                                {{ trans('lang.dashboard') }}
                            </a>
                        </li>
                        <li class="breadcrumb-item active">{{ trans('lang.dashboard') }}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <div class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            @include('dashboard.stat_cards')
        </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-lg-6">
                @include('dashboard.earnings_card')
            </div>

            <div class="col-lg-6">
                @include('dashboard.providers_card')
            </div>
        </div>
    </div>
@endsection

@push('scripts_lib')
    <script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>
@endpush

@push('scripts')
    <script type="text/javascript">
        var data = [1000, 2000, 3000, 2500, 2700, 2500, 3000];
        var labels = ['JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'];

        function renderChart(chartNode, data, labels) {
            var ticksStyle = {
                fontColor: '#495057',
                fontStyle: 'bold'
            };

            var mode = 'index';
            var intersect = true;
            return new Chart(chartNode, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        backgroundColor: '#007bff',
                        borderColor: '#007bff',
                        data: data
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    tooltips: {
                        mode: mode,
                        intersect: intersect
                    },
                    hover: {
                        mode: mode,
                        intersect: intersect
                    },
                    legend: {
                        display: false
                    },
                    scales: {
                        yAxes: [{
                            // display: false,
                            gridLines: {
                                display: true,
                                lineWidth: '4px',
                                color: 'rgba(0, 0, 0, .2)',
                                zeroLineColor: 'transparent'
                            },
                            ticks: $.extend({
                                beginAtZero: true,

                                // Include a dollar sign in the ticks
                                callback: function(value, index, values) {
                                    @if ('1' == '0')
                                        return "{{ setting('default_currency') }} " + value;
                                    @else
                                        return value + " د.إ";
                                    @endif

                                }
                            }, ticksStyle)
                        }],
                        xAxes: [{
                            display: true,
                            gridLines: {
                                display: false
                            },
                            ticks: ticksStyle
                        }]
                    }
                }
            })
        }

        $(function() {
            'use strict'

            var $salesChart = $('#sales-chart')
            $.ajax({
                url: "https://abdelrahman-salah.online/api/payments/byMonth?api_token=PivvPlsQWxPl1bB5KrbKNBuraJit0PrUZekQUgtLyTRuyBq921atFtoR1HuA",
                success: function(result) {
                    $("#loadingMessage").html("");
                    var data = result.data[0];
                    var labels = result.data[1];
                    renderChart($salesChart, data, labels)
                },
                error: function(err) {
                    $("#loadingMessage").html("Error");
                }
            });
            //var salesChart = renderChart($salesChart, data, labels);
        })
    </script>
@endpush
