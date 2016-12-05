@extends('layouts.app')

@section('header')
<script src="https://code.highcharts.com/stock/highstock.js"></script>
<script src="https://code.highcharts.com/stock/modules/exporting.js"></script>
@endsection

@section('content')

<?php
// Temperature
$tempOver = [];
foreach ($tempWeathers as $tempWeather) {
    extract((array) $tempWeather);
    //$timeGMT = new DateTime($tempWeather->timeweather, new DateTimeZone('UTC'));
    //$tempOver[] = array($timeGMT->getTimestamp()*1000, $tempWeather->temperature);
    $tempOver[] = array(strtotime($tempWeather->timeweather . 'GMT') * 1000, $tempWeather->temperature + 0);
}
//print_r($tempOver);
// Humidity
$humidityOver = [];
foreach ($humidityWeathers as $humidityWeather) {
    extract((array) $humidityWeather);
    $humidityOver[] = array(strtotime($humidityWeather->timeweather . 'GMT') * 1000, $humidityWeather->humidity + 0);
}
//print_r($humidityOver);
// Dewpoint
$dewpointOver = [];
foreach ($dewpointWeathers as $dewpointWeather) {
    extract((array) $dewpointWeather);
    $dewpointOver[] = array(strtotime($dewpointWeather->timeweather . 'GMT') * 1000, $dewpointWeather->dewpoint + 0);
}
//print_r($dewpointOver);
// Dewpoint
$pressureOver = [];
foreach ($pressureWeathers as $pressureWeather) {
    extract((array) $pressureWeather);
    $pressureOver[] = array(strtotime($pressureWeather->timeweather . 'GMT') * 1000, $pressureWeather->pressure + 0);
}
//print_r($pressureOver);
// RAIN
$rainOver = [];
foreach ($rainWeathers as $rainWeather) {
    extract((array) $rainWeather);
    $rainOver[] = array(strtotime($rainWeather->timeweather . 'GMT') * 1000, $rainWeather->rain + 0);
}
//print_r($rainOver);

$chartTemp = [
    'rangeSelector' => [
        'selected' => 1,
        'buttons' => [
            [
                'type' => 'hour',
                'count' => 1,
                'text' => '1h'
            ],
            [
                'type' => 'hour',
                'count' => 6,
                'text' => '6h'
            ],
            [
                'type' => 'hour',
                'count' => 12,
                'text' => '12h'
            ],
            [
                'type' => 'day',
                'count' => 1,
                'text' => '1d'
            ],
            [
                'type' => 'week',
                'count' => 1,
                'text' => '1w'
            ],
            [
                'type' => 'month',
                'count' => 1,
                'text' => '1m',
            ],
            [
                'type' => 'month',
                'count' => 3,
                'text' => '3m'
            ],
            [
                'type' => 'month',
                'count' => 6,
                'text' => '6m'
            ],
            [
                'type' => 'ytd',
                'text' => 'YTD'
            ],
            [
                'type' => 'year',
                'count' => 1,
                'text' => '1y'
            ],
            [
                'type' => 'all',
                'text' => 'ALL'
            ],
        ],
    ],
    'title' => [
        'text' => 'Temperature Weather'
    ],
    'credits' => ['enabled' => false],
    'xAxis' => [
        'title' => [
            'text' => 'Timestamp'
        ]
    ],
    'yAxis' => [
        [
            'labels' => [
                'align' => 'right',
                'x' => -3
            ],
            'title' => [
                'text' => 'degree Celsius'
            ],
            'height' => '60%',
        //'max' => 100,
        //'min' => 0,
        ],
        [
            'labels' => [
                'align' => 'right',
                'x' => -3
            ],
            'title' => [
                'text' => 'Rain'
            ],
            'top' => '65%',
            'height' => '35%',
            'offset' => 0,
        ]
    ],
    'series' => [
        [
            'name' => 'Temperature',
            'marker' => [
                'enabled' => true,
                'radius' => 3
            ],
            'data' => $tempOver,
            //'step' => true,
            'tooltip' => [
                'enabled' => true,
                'valueDecimals' => 2,
                'valueSuffix' => ' °C'
            ],
        ],
        [
            //'type' => 'column',
            'name' => 'Rain',
            'step' => true,
            'data' => $rainOver,
            'yAxis' => 1,
        ],
    ]
];


$chartHumidity = [
    'rangeSelector' => [
        'selected' => 1,
        'buttons' => [
            [
                'type' => 'hour',
                'count' => 1,
                'text' => '1h'
            ],
            [
                'type' => 'hour',
                'count' => 6,
                'text' => '6h'
            ],
            [
                'type' => 'hour',
                'count' => 12,
                'text' => '12h'
            ],
            [
                'type' => 'day',
                'count' => 1,
                'text' => '1d'
            ],
            [
                'type' => 'week',
                'count' => 1,
                'text' => '1w'
            ],
            [
                'type' => 'month',
                'count' => 1,
                'text' => '1m',
            ],
            [
                'type' => 'month',
                'count' => 3,
                'text' => '3m'
            ],
            [
                'type' => 'month',
                'count' => 6,
                'text' => '6m'
            ],
            [
                'type' => 'ytd',
                'text' => 'YTD'
            ],
            [
                'type' => 'year',
                'count' => 1,
                'text' => '1y'
            ],
            [
                'type' => 'all',
                'text' => 'ALL'
            ],
        ],
    ],
    'title' => [
        'text' => 'Humidity Weather'
    ],
    'credits' => ['enabled' => false],
    'xAxis' => [
        'title' => [
            'text' => 'Timestamp'
        ]
    ],
    'yAxis' => [
        [
            'labels' => [
                'align' => 'right',
                'x' => -3
            ],
            'title' => [
                'text' => '%'
            ],
            'height' => '60%',
        ],
        [
            'labels' => [
                'align' => 'right',
                'x' => -3
            ],
            'title' => [
                'text' => 'Rain'
            ],
            'top' => '65%',
            'height' => '35%',
            'offset' => 0,
        ]
    ],
    'series' => [
        [
            'name' => 'Humidity',
            'marker' => [
                'enabled' => true,
                'radius' => 3
            ],
            'data' => $humidityOver,
            //'step' => true,
            'tooltip' => [
                'enabled' => true,
                'valueDecimals' => 2,
                'valueSuffix' => ' %'
            ],
        ],
        [
            //'type' => 'column',
            'name' => 'Rain',
            'step' => true,
            'data' => $rainOver,
            'yAxis' => 1,
        ],
    ]
];

$chartDewpoint = [
    'rangeSelector' => [
        'selected' => 1,
        'buttons' => [
            [
                'type' => 'hour',
                'count' => 1,
                'text' => '1h'
            ],
            [
                'type' => 'hour',
                'count' => 6,
                'text' => '6h'
            ],
            [
                'type' => 'hour',
                'count' => 12,
                'text' => '12h'
            ],
            [
                'type' => 'day',
                'count' => 1,
                'text' => '1d'
            ],
            [
                'type' => 'week',
                'count' => 1,
                'text' => '1w'
            ],
            [
                'type' => 'month',
                'count' => 1,
                'text' => '1m',
            ],
            [
                'type' => 'month',
                'count' => 3,
                'text' => '3m'
            ],
            [
                'type' => 'month',
                'count' => 6,
                'text' => '6m'
            ],
            [
                'type' => 'ytd',
                'text' => 'YTD'
            ],
            [
                'type' => 'year',
                'count' => 1,
                'text' => '1y'
            ],
            [
                'type' => 'all',
                'text' => 'ALL'
            ],
        ],
    ],
    'title' => [
        'text' => 'Dewpoint Weather'
    ],
    'credits' => ['enabled' => false],
    'xAxis' => [
        'title' => [
            'text' => 'Timestamp'
        ]
    ],
    'yAxis' => [
        [
            'labels' => [
                'align' => 'right',
                'x' => -3
            ],
            'title' => [
                'text' => 'degree Celsius'
            ],
            'height' => '60%',
        ],
        [
            'labels' => [
                'align' => 'right',
                'x' => -3
            ],
            'title' => [
                'text' => 'Rain'
            ],
            'top' => '65%',
            'height' => '35%',
            'offset' => 0,
        ]
    ],
    'series' => [
        [
            'name' => 'Dewpoint',
            'marker' => [
                'enabled' => true,
                'radius' => 3
            ],
            'data' => $dewpointOver,
            //'step' => true,
            'tooltip' => [
                'enabled' => true,
                'valueDecimals' => 2,
                'valueSuffix' => ' °C'
            ],
        ],
        [
            //'type' => 'column',
            'name' => 'Rain',
            'step' => true,
            'data' => $rainOver,
            'yAxis' => 1,
        ],
    ]
];

$chartPressure = [
    'rangeSelector' => [
        'selected' => 1,
        'buttons' => [
            [
                'type' => 'hour',
                'count' => 1,
                'text' => '1h'
            ],
            [
                'type' => 'hour',
                'count' => 6,
                'text' => '6h'
            ],
            [
                'type' => 'hour',
                'count' => 12,
                'text' => '12h'
            ],
            [
                'type' => 'day',
                'count' => 1,
                'text' => '1d'
            ],
            [
                'type' => 'week',
                'count' => 1,
                'text' => '1w'
            ],
            [
                'type' => 'month',
                'count' => 1,
                'text' => '1m',
            ],
            [
                'type' => 'month',
                'count' => 3,
                'text' => '3m'
            ],
            [
                'type' => 'month',
                'count' => 6,
                'text' => '6m'
            ],
            [
                'type' => 'ytd',
                'text' => 'YTD'
            ],
            [
                'type' => 'year',
                'count' => 1,
                'text' => '1y'
            ],
            [
                'type' => 'all',
                'text' => 'ALL'
            ],
        ],
    ],
    'title' => [
        'text' => 'Pressure Weather'
    ],
    'credits' => ['enabled' => false],
    'xAxis' => [
        'title' => [
            'text' => 'Timestamp'
        ]
    ],
    'yAxis' => [
        [
            'labels' => [
                'align' => 'right',
                'x' => -3
            ],
            'title' => [
                'text' => 'hPa'
            ],
            'height' => '60%',
        ],
        [
            'labels' => [
                'align' => 'right',
                'x' => -3
            ],
            'title' => [
                'text' => 'Rain'
            ],
            'top' => '65%',
            'height' => '35%',
            'offset' => 0,
        ]
    ],
    'series' => [
        [
            'name' => 'Pressure',
            'marker' => [
                'enabled' => true,
                'radius' => 3
            ],
            'data' => $pressureOver,
            //'step' => true,
            'tooltip' => [
                'enabled' => true,
                'valueDecimals' => 2,
                'valueSuffix' => ' hPa'
            ],
        ],
        [
            //'type' => 'column',
            'name' => 'Rain',
            'step' => true,
            'data' => $rainOver,
            'yAxis' => 1,
        ],
    ]
];

$chartLight = [
    'rangeSelector' => [
        'selected' => 1,
        'buttons' => [
            [
                'type' => 'hour',
                'count' => 1,
                'text' => '1h'
            ],
            [
                'type' => 'hour',
                'count' => 6,
                'text' => '6h'
            ],
            [
                'type' => 'hour',
                'count' => 12,
                'text' => '12h'
            ],
            [
                'type' => 'day',
                'count' => 1,
                'text' => '1d'
            ],
            [
                'type' => 'week',
                'count' => 1,
                'text' => '1w'
            ],
            [
                'type' => 'month',
                'count' => 1,
                'text' => '1m',
            ],
            [
                'type' => 'month',
                'count' => 3,
                'text' => '3m'
            ],
            [
                'type' => 'month',
                'count' => 6,
                'text' => '6m'
            ],
            [
                'type' => 'ytd',
                'text' => 'YTD'
            ],
            [
                'type' => 'year',
                'count' => 1,
                'text' => '1y'
            ],
            [
                'type' => 'all',
                'text' => 'ALL'
            ],
        ],
    ],
    'title' => [
        'text' => 'Light Weather'
    ],
    'credits' => ['enabled' => false],
    'xAxis' => [
        'title' => [
            'text' => 'Timestamp'
        ]
    ],
    'yAxis' => [
        [
            'labels' => [
                'align' => 'right',
                'x' => -3
            ],
            'title' => [
                'text' => 'Light (lux)'
            ],
            'height' => '60%',
        ],
        [
            'labels' => [
                'align' => 'right',
                'x' => -3
            ],
            'title' => [
                'text' => 'Rain'
            ],
            'top' => '65%',
            'height' => '35%',
            'offset' => 0,
        ]
    ],
    'series' => [
        [
            'name' => 'Light',
            'marker' => [
                'enabled' => true,
                'radius' => 3
            ],
            'data' => $pressureOver,
            //'step' => true,
            'tooltip' => [
                'enabled' => true,
                'valueDecimals' => 2,
                'valueSuffix' => ' lux'
            ],
        ],
        [
            //'type' => 'column',
            'name' => 'Rain',
            'step' => true,
            'data' => $rainOver,
            'yAxis' => 1,
        ],
    ]
];
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-primary" >
                <div class="panel-heading"><h4>Overview</h4></div>
                <div class="panel-body">
                    <div class="col-md-12">
                        <div class="panel panel-success ">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-list fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <h3>{{ $countW }}</h3>
                                        <h4>Lists</h4>
                                    </div>
                                </div>
                            </div>
                            <a href="{{ url('/weather') }}">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-custom-horrible-blue">
                <div class="panel-heading">Temperature</div>
                {!! Chart::display("Temperature", $chartTemp) !!}
            </div>
        </div>
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-custom-horrible-blue" >
                <div class="panel-heading">Humidity</div>
                {!! Chart::display("Humidity", $chartHumidity) !!}
            </div>
        </div>
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-custom-horrible-blue" >
                <div class="panel-heading">Dewpoint</div>
                {!! Chart::display("Dewpoint", $chartDewpoint) !!}
            </div>
        </div>
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-custom-horrible-blue" >
                <div class="panel-heading">Pressure</div>
                {!! Chart::display("Pressure", $chartPressure) !!}
            </div>
        </div>
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-custom-horrible-blue" >
                <div class="panel-heading">Light</div>
                {!! Chart::display("Light", $chartLight) !!}
            </div>
        </div>
    </div>
</div>

@endsection
