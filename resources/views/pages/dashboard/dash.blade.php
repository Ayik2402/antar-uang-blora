@extends('layouts.main')

@section('content')

<div class="layout-px-spacing">
    <div class="row layout-top-spacing">
        <div class="col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
            <div class="widget widget-chart-one">
                <div class="widget-content">
                    <div id="chartsbrt"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
            <div class="widget widget-chart-two">
                <div class="widget-heading">
                    <h5 class="">Status Transaksi Bulan {{ \Carbon\Carbon::now()->isoFormat('MMMM YYYY') }}</h5>
                </div>
                <div class="widget-content">
                    <div id="chart-two" class=""></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="text-uppercase">Data permohonan transaksi</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" width="100%" id="default-ordering">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Nasabah</th>
                                    <th>Jenis transfer</th>
                                    <th>No. rekening</th>
                                    <th>Tujuan rekening</th>
                                    <th>Nominal</th>
                                    <th>Biaya</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tfsesama as $key => $value)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($value->created_at)->format('Y-m-d H:i:s') }}</td>
                                    <td>{{$value->nasabah}}</td>
                                    <td><span class="badge badge-info text-uppercase">Transfer sesama rekening</span></td>
                                    <td>{{$value->norek}}</td>
                                    <td>{{$value->rekening_tujuan}}</td>
                                    <td>Rp. {{number_format($value->nominal)}}</td>
                                    <td>Rp. 0</td>
                                    <td>Rp. {{number_format($value->nominal)}}</td>
                                    <td>
                                        @if($value->status_transaksi == 1)
                                        <span class="badge badge-warning text-uppercase">pending</span>
                                        @elseif($value->status_transaksi == 2)
                                        <span class="badge badge-success text-uppercase">sukses</span>
                                        @else
                                        <span class="badge badge-danger text-uppercase">batal</span>
                                        @endif
                                    </td>

                                </tr>
                                @endforeach
                                @foreach($tfbnk as $key => $value)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($value->created_at)->format('Y-m-d H:i:s') }}</td>
                                    <td>{{$value->nasabah}}</td>
                                    <td><span class="badge badge-primary text-uppercase">Transfer antar bank {{$value->bank}}</span></td>
                                    <td>{{$value->norek}}</td>
                                    <td><b>{{$value->rekening_penerima}}</b> - {{$value->rekening_tujuan}}</td>
                                    <td>Rp. {{number_format($value->nominal)}}</td>
                                    <td>Rp. {{number_format($value->biaya)}}</td>
                                    <td>Rp. {{number_format($value->jumlah)}}</td>
                                    <td>
                                        @if($value->status_transaksi == 1)
                                        <span class="badge badge-warning text-uppercase">pending</span>
                                        @else
                                        <span class="badge badge-success text-uppercase">sukses</span>
                                        @endif
                                    </td>

                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // START LINE CHART

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        jQuery.ajax({
            url: '/linechart',
            method: 'get',
            success: function(result) {
                var options1 = {
                    chart: {
                        fontFamily: 'Nunito, sans-serif',
                        height: 405,
                        type: 'area',
                        zoom: {
                            enabled: false
                        },
                        dropShadow: {
                            enabled: true,
                            opacity: 0.2,
                            blur: 10,
                            left: -7,
                            top: 22
                        },
                        toolbar: {
                            show: false
                        },
                        events: {
                            mounted: function(ctx, config) {
                                const highest1 = ctx.getHighestValueInSeries(0);
                                const highest2 = ctx.getHighestValueInSeries(1);

                                ctx.addPointAnnotation({
                                    x: new Date(ctx.w.globals.seriesX[0][ctx.w.globals.series[0].indexOf(highest1)]).getTime(),
                                    y: highest1,
                                    label: {
                                        style: {
                                            cssClass: 'd-none'
                                        }
                                    },
                                    customSVG: {
                                        SVG: '<svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="#1b55e2" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="feather feather-circle"><circle cx="12" cy="12" r="10"></circle></svg>',
                                        cssClass: undefined,
                                        offsetX: -8,
                                        offsetY: 5
                                    }
                                })

                                ctx.addPointAnnotation({
                                    x: new Date(ctx.w.globals.seriesX[1][ctx.w.globals.series[1].indexOf(highest2)]).getTime(),
                                    y: highest2,
                                    label: {
                                        style: {
                                            cssClass: 'd-none'
                                        }
                                    },
                                    customSVG: {
                                        SVG: '<svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="#e7515a" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="feather feather-circle"><circle cx="12" cy="12" r="10"></circle></svg>',
                                        cssClass: undefined,
                                        offsetX: -8,
                                        offsetY: 5
                                    }
                                })
                            },
                        }
                    },
                    colors: ['#1b55e2', '#e7515a', '#70db70', '#ff4d94', '#ffff4d', '#d580ff', '#80ffe5', '#80d4ff'],
                    dataLabels: {
                        enabled: false
                    },
                    markers: {
                        discrete: [{
                            seriesIndex: 0,
                            dataPointIndex: 7,
                            fillColor: '#000',
                            strokeColor: '#000',
                            size: 5
                        }, {
                            seriesIndex: 2,
                            dataPointIndex: 11,
                            fillColor: '#000',
                            strokeColor: '#000',
                            size: 4
                        }]
                    },
                    // subtitle: {
                    //     text: '',
                    //     align: 'left',
                    //     margin: 0,
                    //     offsetX: 95,
                    //     offsetY: 0,
                    //     floating: false,
                    //     style: {
                    //         fontSize: '18px',
                    //         color: '#4361ee'
                    //     }
                    // },
                    title: {
                        text: 'Transaksi Per Bulan',
                        align: 'left',
                        margin: 27,
                        offsetX: 0,
                        offsetY: 0,
                        floating: false,
                        style: {
                            fontSize: '20px',
                            color: '#0e1726'
                        },
                    },
                    stroke: {
                        show: true,
                        curve: 'smooth',
                        width: 2,
                        lineCap: 'square'
                    },
                    series: [{
                            name: 'Transfer antar bank',
                            data: result.tfantarbank
                        }, {
                            name: 'Transfer sesama rekening',
                            data: result.tfsesama
                        },

                    ],
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    xaxis: {
                        axisBorder: {
                            show: false
                        },
                        axisTicks: {
                            show: false
                        },
                        crosshairs: {
                            show: true
                        },
                        labels: {
                            offsetX: 0,
                            offsetY: 5,
                            style: {
                                fontSize: '12px',
                                fontFamily: 'Nunito, sans-serif',
                                cssClass: 'apexcharts-xaxis-title',
                            },
                        }
                    },
                    yaxis: {
                        labels: {
                            formatter: function(value, index) {
                                // return (value / 1000) + 'K'
                                // console.log(value)
                                return new Intl.NumberFormat('id-ID', {
                                    style: "currency",
                                    currency: "IDR",
                                    minimumFractionDigits: 0,
                                    maximumFractionDigits: 0
                                }).format(value);
                                // return value
                            },
                            offsetX: -22,
                            offsetY: 0,
                            style: {
                                fontSize: '12px',
                                fontFamily: 'Nunito, sans-serif',
                                cssClass: 'apexcharts-yaxis-title',
                            },
                        }
                    },
                    grid: {
                        borderColor: '#e0e6ed',
                        strokeDashArray: 5,
                        xaxis: {
                            lines: {
                                show: true
                            }
                        },
                        yaxis: {
                            lines: {
                                show: false,
                            }
                        },
                        padding: {
                            top: 0,
                            right: 0,
                            bottom: 0,
                            left: -10
                        },
                    },
                    legend: {
                        position: 'top',
                        horizontalAlign: 'right',
                        offsetY: -50,
                        fontSize: '16px',
                        fontFamily: 'Nunito, sans-serif',
                        markers: {
                            width: 10,
                            height: 10,
                            strokeWidth: 0,
                            strokeColor: '#fff',
                            fillColors: undefined,
                            radius: 12,
                            onClick: undefined,
                            offsetX: 0,
                            offsetY: 0
                        },
                        itemMargin: {
                            horizontal: 0,
                            vertical: 20
                        }
                    },
                    tooltip: {
                        theme: 'dark',
                        marker: {
                            show: true,
                        },
                        x: {
                            show: false,
                        }
                    },
                    fill: {
                        type: "gradient",
                        gradient: {
                            type: "vertical",
                            shadeIntensity: 1,
                            inverseColors: !1,
                            opacityFrom: .28,
                            opacityTo: .05,
                            stops: [45, 100]
                        }
                    },
                    responsive: [{
                        breakpoint: 575,
                        options: {
                            legend: {
                                offsetY: -30,
                            },
                        },
                    }]
                }


                var chart1 = new ApexCharts(
                    document.querySelector("#chartsbrt"),
                    options1
                );

                chart1.render();
                // END CHART LINE


                // START CHART DONUT

                var optionsss = {
                    chart: {
                        type: 'donut',
                        width: 380
                    },
                    colors: ['#e2a03f', '#1abc9c', '#e7515a'],
                    dataLabels: {
                        enabled: false
                    },
                    legend: {
                        position: 'bottom',
                        horizontalAlign: 'center',
                        fontSize: '14px',
                        markers: {
                            width: 10,
                            height: 10,
                        },
                        itemMargin: {
                            horizontal: 0,
                            vertical: 8
                        }
                    },
                    plotOptions: {
                        pie: {
                            donut: {
                                size: '65%',
                                background: 'transparent',
                                labels: {
                                    show: true,
                                    name: {
                                        show: true,
                                        fontSize: '29px',
                                        fontFamily: 'Nunito, sans-serif',
                                        color: undefined,
                                        offsetY: -10
                                    },
                                    value: {
                                        show: true,
                                        fontSize: '26px',
                                        fontFamily: 'Nunito, sans-serif',
                                        color: '20',
                                        offsetY: 16,
                                        formatter: function(val) {
                                            // return val
                                            return Number(val)
                                        }
                                    },
                                    total: {
                                        show: true,
                                        showAlways: true,
                                        label: 'Total',
                                        color: '#888ea8',
                                        formatter: function(w) {
                                            return w.globals.seriesTotals.reduce(function(a, b) {
                                                return a + b
                                            }, 0)
                                        }
                                    }
                                }
                            }
                        }
                    },
                    stroke: {
                        show: true,
                        width: 25,
                    },
                    series: result.status,
                    labels: ['PENDING', 'SUKSES', 'BATAL'],
                    responsive: [{
                        breakpoint: 1599,
                        options: {
                            chart: {
                                width: '350px',
                                height: '400px'
                            },
                            legend: {
                                position: 'bottom'
                            }
                        },

                        breakpoint: 1439,
                        options: {
                            chart: {
                                width: '250px',
                                height: '390px'
                            },
                            legend: {
                                position: 'bottom'
                            },
                            plotOptions: {
                                pie: {
                                    donut: {
                                        size: '65%',
                                    }
                                }
                            }
                        },
                    }]
                }

                var chartss = new ApexCharts(
                    document.querySelector("#chart-two"),
                    optionsss
                );

                chartss.render();

                // END CHART DONUT
            },
        })





    })
</script>
@endsection