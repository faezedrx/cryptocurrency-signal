<?php

// تابع برای دریافت داده‌ها از CoinGecko
function get_coingecko_data($symbol, $vs_currency = 'usd', $days = '30') {
    $url = "https://api.coingecko.com/api/v3/coins/$symbol/market_chart";
    $params = [
        'vs_currency' => $vs_currency,
        'days' => $days
    ];

    $query = http_build_query($params);
    $response = file_get_contents("$url?$query");
    $data = json_decode($response, true);

    return $data['prices'];
}

// تابع برای تبدیل داده‌ها به فرم دلخواه
function convert_to_dataframe($data) {
    $df = [];
    foreach ($data as $entry) {
        $time = date('Y-m-d H:i:s', $entry[0] / 1000); // تبدیل زمان
        $price = $entry[1];
        $df[$time] = [
            'price' => $price,
            'high' => $price,
            'low' => $price,
            'close' => $price
        ];
    }
    return $df;
}

// تابع محاسبه ایچیموکو
function ichimoku($highs, $lows, $closes) {
    $tenkan_sen = (max(array_slice($highs, -9)) + min(array_slice($lows, -9))) / 2;
    $kijun_sen = (max(array_slice($highs, -26)) + min(array_slice($lows, -26))) / 2;
    $senkou_span_a = ($tenkan_sen + $kijun_sen) / 2;
    $senkou_span_b = (max(array_slice($highs, -52)) + min(array_slice($lows, -52))) / 2;
    $chikou_span = end($closes); // قیمت پایانی

    return [$tenkan_sen, $kijun_sen, $senkou_span_a, $senkou_span_b, $chikou_span];
}

// تابع تولید سیگنال
function generate_signal($close, $tenkan_sen, $kijun_sen) {
    $last_close = end($close);
    if ($last_close > $kijun_sen && $tenkan_sen > $kijun_sen) {
        return ['signal' => 'Buy', 'stop_loss' => $last_close * 0.98, 'take_profit' => $last_close * 1.05];
    } elseif ($last_close < $kijun_sen && $tenkan_sen < $kijun_sen) {
        return ['signal' => 'Sell', 'stop_loss' => $last_close * 1.02, 'take_profit' => $last_close * 0.95];
    } else {
        return ['signal' => 'Hold', 'stop_loss' => null, 'take_profit' => null];
    }
}

// دریافت اطلاعات و محاسبه سیگنال
if (isset($_GET['symbol'])) {
    $symbol = $_GET['symbol'];
    $data = get_coingecko_data($symbol);
    $df = convert_to_dataframe($data);

    $highs = array_column($df, 'high');
    $lows = array_column($df, 'low');
    $closes = array_column($df, 'close');

    list($tenkan_sen, $kijun_sen, $senkou_span_a, $senkou_span_b, $chikou_span) = ichimoku($highs, $lows, $closes);

    $signal = generate_signal($closes, $tenkan_sen, $kijun_sen);

    header('Content-Type: application/json');
    echo json_encode($signal);
}

?>
