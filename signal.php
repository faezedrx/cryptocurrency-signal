<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crypto Ichimoku Analysis</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* انیمیشن لودینگ */
        @keyframes spinner {
            to {transform: rotate(360deg);}
        }
        .spinner {
            width: 24px;
            height: 24px;
            border: 4px solid transparent;
            border-top-color: #3498db;
            border-radius: 50%;
            animation: spinner 0.6s linear infinite;
        }
    </style>
</head>
<body class="bg-gray-100">

<div class="container mx-auto p-6">
    <div class="bg-white shadow-md rounded-lg p-6 max-w-lg mx-auto">
        <h1 class="text-2xl font-bold mb-4 text-center text-gray-700">Cryptocurrency Technical Analysis</h1>

        <!-- انتخاب اندیکاتور -->
        <div class="mb-4">
            <label for="indicator" class="block text-lg font-semibold mb-2 text-gray-600">Choose Indicator:</label>
            <select id="indicator" class="p-3 border border-gray-300 rounded w-full">
                <option value="ichimoku">Ichimoku</option>
                <!-- سایر اندیکاتورها -->
            </select>
        </div>

        <!-- انتخاب ارز -->
        <div class="mb-4">
            <label for="symbol" class="block text-lg font-semibold mb-2 text-gray-600">Choose Cryptocurrency:</label>
            <select id="symbol" class="p-3 border border-gray-300 rounded w-full">
                <option value="bitcoin">Bitcoin</option>
                <option value="ethereum">Ethereum</option>
                <option value="binancecoin">Binance Coin</option>
                <option value="cardano">Cardano</option>
                <option value="solana">Solana</option>
                <option value="polkadot">Polkadot</option>
                <option value="pepe">Pepe</option>
                <option value="ripple">Ripple</option>
                <option value="dogecoin">Dogecoin</option>
                <option value="chainlink">Chainlink</option>
                <option value="shiba-inu">Shiba Inu</option>
            </select>
        </div>

        <!-- دکمه برای نمایش تحلیل -->
        <button onclick="loadAnalysis()" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded w-full flex items-center justify-center">
            <span id="loadText">Load Analysis</span>
            <div id="spinner" class="spinner hidden ml-2"></div>
        </button>

        <!-- بخش نمایش سیگنال -->
        <div id="signalResult" class="mt-6 p-4 bg-white border border-gray-200 rounded shadow hidden">
            <h2 class="text-xl font-semibold text-gray-700">Signal Result:</h2>
            <p id="signalText" class="text-gray-600"></p>
        </div>
    </div>
</div>

<script>
    function loadAnalysis() {
        // نمایش لودینگ
        document.getElementById('spinner').classList.remove('hidden');
        document.getElementById('loadText').textContent = 'Loading...';

        const symbol = document.getElementById('symbol').value;
        const indicator = document.getElementById('indicator').value;

        if (indicator === 'ichimoku') {
            fetch(`get_ichimoku_signal.php?symbol=${symbol}`)
                .then(response => response.json())
                .then(data => {
                    // مخفی کردن لودینگ
                    document.getElementById('spinner').classList.add('hidden');
                    document.getElementById('loadText').textContent = 'Load Analysis';

                    // نمایش نتیجه سیگنال
                    document.getElementById('signalResult').classList.remove('hidden');
                    document.getElementById('signalText').innerHTML = `
                        <strong>Signal:</strong> ${data.signal} <br>
                        <strong>Stop Loss:</strong> ${data.stop_loss ? data.stop_loss : 'N/A'} <br>
                        <strong>Take Profit:</strong> ${data.take_profit ? data.take_profit : 'N/A'}
                    `;
                });
        }
    }
</script>

</body>
</html>
