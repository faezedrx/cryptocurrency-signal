# CryptoCurrency Signal

A simple cryptocurrency technical analysis web app built with PHP and JavaScript. The application currently provides Ichimoku-based signals for various cryptocurrencies, with more indicators coming soon.

## Features

- **TailwindCSS** for responsive UI.
- **CoinGecko API** integration to fetch historical market data.
- **Ichimoku Indicator** for cryptocurrency technical analysis.
- Asynchronous analysis loading using **fetch API** and real-time signal generation.
- Signals include **Buy**, **Sell**, or **Hold**, along with recommended **Stop Loss** and **Take Profit** levels.

## Project Structure

- `signal.php`: The main front-end file with a user interface for selecting indicators and cryptocurrencies. It sends requests to fetch technical analysis data.
- `get_ichimoku_signal.php`: Backend script to fetch cryptocurrency data from CoinGecko API, compute Ichimoku indicators, and return a signal based on current market conditions.

## Usage

1. Clone the repository:
   ```bash
   git clone https://github.com/faezedrx/cryptocurrency-signal.git
   ```
2. Navigate to the project directory:
   ```bash
   cd cryptocurrency-signal
   ```
3. Ensure your server supports PHP and has internet access to fetch data from CoinGecko API.
4. Open `signal.php` in your browser to start using the application. Select a cryptocurrency and indicator, and click "Load Analysis" to view the signal.

## How it Works

### Frontend (`signal.php`):
   - The user selects an indicator and cryptocurrency from dropdown menus.
   - When "Load Analysis" is clicked, an AJAX request is sent to the backend.
   - A loading spinner appears while waiting for the response.
   - Once the data is received, the signal results (Buy, Sell, Hold) along with Stop Loss and Take Profit values are displayed in a user-friendly format.

### Backend (`get_ichimoku_signal.php`):
   - The backend fetches 30 days of historical cryptocurrency price data from the CoinGecko API.
   - This data is processed and formatted to perform Ichimoku analysis.
   - The Ichimoku formula is applied to calculate key values such as Tenkan-sen, Kijun-sen, and Senkou Span.
   - Based on these values, a trading signal (Buy, Sell, or Hold) is generated, along with recommended Stop Loss and Take Profit levels.
   - The result is returned as a JSON object to the frontend.

## Example Request

```bash
GET /get_ichimoku_signal.php?symbol=bitcoin
```

### Example Response:
```bash
{
  "signal": "Buy",
  "stop_loss": 43500.50,
  "take_profit": 50000.75
}
```

## Future Plans

- **Additional Indicators**: Plan to implement popular technical indicators such as RSI (Relative Strength Index), MACD (Moving Average Convergence Divergence), and Moving Averages.
- **More Cryptocurrencies**: Expand the list of supported cryptocurrencies beyond the current selection.
- **Improved Signal Logic**: Enhance the accuracy of trading signals by combining multiple indicators and optimizing the decision-making process.
- **User Accounts**: Add functionality for users to save preferences, track their analysis, and receive notifications.


