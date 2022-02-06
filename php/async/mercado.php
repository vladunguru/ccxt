<?php

namespace ccxt\async;

// PLEASE DO NOT EDIT THIS FILE, IT IS GENERATED AND WILL BE OVERWRITTEN:
// https://github.com/ccxt/ccxt/blob/master/CONTRIBUTING.md#how-to-contribute-code

use Exception; // a common import
use \ccxt\ExchangeError;
use \ccxt\ArgumentsRequired;
use \ccxt\InvalidOrder;
use \ccxt\Precise;

class mercado extends Exchange {

    public function describe() {
        return $this->deep_extend(parent::describe (), array(
            'id' => 'mercado',
            'name' => 'Mercado Bitcoin',
            'countries' => array( 'BR' ), // Brazil
            'rateLimit' => 1000,
            'version' => 'v3',
            'has' => array(
                'CORS' => true,
                'spot' => true,
                'margin' => false,
                'swap' => false,
                'future' => false,
                'option' => false,
                'addMargin' => false,
                'cancelOrder' => true,
                'createMarketOrder' => true,
                'createOrder' => true,
                'createReduceOnlyOrder' => false,
                'fetchBalance' => true,
                'fetchBorrowRate' => false,
                'fetchBorrowRateHistory' => false,
                'fetchBorrowRates' => false,
                'fetchBorrowRatesPerSymbol' => false,
                'fetchFundingHistory' => false,
                'fetchFundingRate' => false,
                'fetchFundingRateHistory' => false,
                'fetchFundingRates' => false,
                'fetchIndexOHLCV' => false,
                'fetchIsolatedPositions' => false,
                'fetchLeverage' => false,
                'fetchMarkets' => true,
                'fetchMarkOHLCV' => false,
                'fetchMyTrades' => 'emulated',
                'fetchOHLCV' => true,
                'fetchOpenOrders' => true,
                'fetchOrder' => true,
                'fetchOrderBook' => true,
                'fetchOrders' => true,
                'fetchPosition' => false,
                'fetchPositions' => false,
                'fetchPositionsRisk' => false,
                'fetchPremiumIndexOHLCV' => false,
                'fetchTicker' => true,
                'fetchTickers' => null,
                'fetchTrades' => true,
                'reduceMargin' => false,
                'setLeverage' => false,
                'setMarginMode' => false,
                'setPositionMode' => false,
                'withdraw' => true,
            ),
            'timeframes' => array(
                '1m' => '1m',
                '5m' => '5m',
                '15m' => '15m',
                '30m' => '30m',
                '1h' => '1h',
                '6h' => '6h',
                '12h' => '12h',
                '1d' => '1d',
                '3d' => '3d',
                '1w' => '1w',
                '2w' => '2w',
            ),
            'urls' => array(
                'logo' => 'https://user-images.githubusercontent.com/1294454/27837060-e7c58714-60ea-11e7-9192-f05e86adb83f.jpg',
                'api' => array(
                    'public' => 'https://www.mercadobitcoin.net/api',
                    'private' => 'https://www.mercadobitcoin.net/tapi',
                    'v4Public' => 'https://www.mercadobitcoin.com.br/v4',
                ),
                'www' => 'https://www.mercadobitcoin.com.br',
                'doc' => array(
                    'https://www.mercadobitcoin.com.br/api-doc',
                    'https://www.mercadobitcoin.com.br/trade-api',
                ),
            ),
            'api' => array(
                'public' => array(
                    'get' => array(
                        'coins',
                        '{coin}/orderbook/', // last slash critical
                        '{coin}/ticker/',
                        '{coin}/trades/',
                        '{coin}/trades/{from}/',
                        '{coin}/trades/{from}/{to}',
                        '{coin}/day-summary/{year}/{month}/{day}/',
                    ),
                ),
                'private' => array(
                    'post' => array(
                        'cancel_order',
                        'get_account_info',
                        'get_order',
                        'get_withdrawal',
                        'list_system_messages',
                        'list_orders',
                        'list_orderbook',
                        'place_buy_order',
                        'place_sell_order',
                        'place_market_buy_order',
                        'place_market_sell_order',
                        'withdraw_coin',
                    ),
                ),
                'v4Public' => array(
                    'get' => array(
                        '{coin}/candle/',
                    ),
                ),
            ),
            'fees' => array(
                'trading' => array(
                    'maker' => 0.003,
                    'taker' => 0.007,
                ),
            ),
            'options' => array(
                'limits' => array(
                    'BTC' => 0.001,
                    'BCH' => 0.001,
                    'ETH' => 0.01,
                    'LTC' => 0.01,
                    'XRP' => 0.1,
                ),
            ),
        ));
    }

    public function fetch_markets($params = array ()) {
        $response = yield $this->publicGetCoins ($params);
        //
        //     array(
        //         "BCH",
        //         "BTC",
        //         "ETH",
        //         "LTC",
        //         "XRP",
        //         "MBPRK01",
        //         "MBPRK02",
        //         "MBPRK03",
        //         "MBPRK04",
        //         "MBCONS01",
        //         "USDC",
        //         "WBX",
        //         "CHZ",
        //         "MBCONS02",
        //         "PAXG",
        //         "MBVASCO01",
        //         "LINK"
        //     )
        //
        $result = array();
        $amountLimits = $this->safe_value($this->options, 'limits', array());
        for ($i = 0; $i < count($response); $i++) {
            $coin = $response[$i];
            $baseId = $coin;
            $quoteId = 'BRL';
            $base = $this->safe_currency_code($baseId);
            $quote = $this->safe_currency_code($quoteId);
            $id = $quote . $base;
            $priceLimit = '1e-5';
            $result[] = array(
                'id' => $id,
                'symbol' => $base . '/' . $quote,
                'base' => $base,
                'quote' => $quote,
                'settle' => null,
                'baseId' => $baseId,
                'quoteId' => $quoteId,
                'settleId' => null,
                'type' => 'spot',
                'spot' => true,
                'margin' => false,
                'swap' => false,
                'future' => false,
                'option' => false,
                'active' => null,
                'contract' => false,
                'linear' => null,
                'inverse' => null,
                'contractSize' => null,
                'expiry' => null,
                'expiryDatetime' => null,
                'strike' => null,
                'optionType' => null,
                'precision' => array(
                    'amount' => 8,
                    'price' => 5,
                ),
                'limits' => array(
                    'leverage' => array(
                        'min' => null,
                        'max' => null,
                    ),
                    'amount' => array(
                        'min' => $this->safe_number($amountLimits, $baseId),
                        'max' => null,
                    ),
                    'price' => array(
                        'min' => $this->parse_number($priceLimit),
                        'max' => null,
                    ),
                    'cost' => array(
                        'min' => null,
                        'max' => null,
                    ),
                ),
                'info' => $coin,
            );
        }
        return $result;
    }

    public function fetch_order_book($symbol, $limit = null, $params = array ()) {
        yield $this->load_markets();
        $market = $this->market($symbol);
        $request = array(
            'coin' => $market['base'],
        );
        $response = yield $this->publicGetCoinOrderbook (array_merge($request, $params));
        return $this->parse_order_book($response, $symbol);
    }

    public function parse_ticker($ticker, $market = null) {
        //
        //     {
        //         "high":"103.96000000",
        //         "low":"95.00000000",
        //         "vol":"2227.67806598",
        //         "last":"97.91591000",
        //         "buy":"95.52760000",
        //         "sell":"97.91475000",
        //         "open":"99.79955000",
        //         "date":1643382606
        //     }
        //
        $symbol = $this->safe_symbol(null, $market);
        $timestamp = $this->safe_timestamp($ticker, 'date');
        $last = $this->safe_string($ticker, 'last');
        return $this->safe_ticker(array(
            'symbol' => $symbol,
            'timestamp' => $timestamp,
            'datetime' => $this->iso8601($timestamp),
            'high' => $this->safe_string($ticker, 'high'),
            'low' => $this->safe_string($ticker, 'low'),
            'bid' => $this->safe_string($ticker, 'buy'),
            'bidVolume' => null,
            'ask' => $this->safe_string($ticker, 'sell'),
            'askVolume' => null,
            'vwap' => null,
            'open' => null,
            'close' => $last,
            'last' => $last,
            'previousClose' => null,
            'change' => null,
            'percentage' => null,
            'average' => null,
            'baseVolume' => $this->safe_string($ticker, 'vol'),
            'quoteVolume' => null,
            'info' => $ticker,
        ), $market, false);
    }

    public function fetch_ticker($symbol, $params = array ()) {
        yield $this->load_markets();
        $market = $this->market($symbol);
        $request = array(
            'coin' => $market['base'],
        );
        $response = yield $this->publicGetCoinTicker (array_merge($request, $params));
        $ticker = $this->safe_value($response, 'ticker', array());
        //
        //     {
        //         "ticker" => {
        //             "high":"1549.82293000",
        //             "low":"1503.00011000",
        //             "vol":"81.82827101",
        //             "last":"1533.15000000",
        //             "buy":"1533.21018000",
        //             "sell":"1540.09000000",
        //             "open":"1524.71089000",
        //             "date":1643691671
        //         }
        //     }
        //
        return $this->parse_ticker($ticker, $market);
    }

    public function parse_trade($trade, $market = null) {
        $timestamp = $this->safe_timestamp_2($trade, 'date', 'executed_timestamp');
        $symbol = null;
        if ($market !== null) {
            $symbol = $market['symbol'];
        }
        $id = $this->safe_string_2($trade, 'tid', 'operation_id');
        $type = null;
        $side = $this->safe_string($trade, 'type');
        $priceString = $this->safe_string($trade, 'price');
        $amountString = $this->safe_string_2($trade, 'amount', 'quantity');
        $price = $this->parse_number($priceString);
        $amount = $this->parse_number($amountString);
        $cost = $this->parse_number(Precise::string_mul($priceString, $amountString));
        $feeCost = $this->safe_number($trade, 'fee_rate');
        $fee = null;
        if ($feeCost !== null) {
            $fee = array(
                'cost' => $feeCost,
                'currency' => null,
            );
        }
        return array(
            'id' => $id,
            'info' => $trade,
            'timestamp' => $timestamp,
            'datetime' => $this->iso8601($timestamp),
            'symbol' => $symbol,
            'order' => null,
            'type' => $type,
            'side' => $side,
            'takerOrMaker' => null,
            'price' => $price,
            'amount' => $amount,
            'cost' => $cost,
            'fee' => $fee,
        );
    }

    public function fetch_trades($symbol, $since = null, $limit = null, $params = array ()) {
        yield $this->load_markets();
        $market = $this->market($symbol);
        $method = 'publicGetCoinTrades';
        $request = array(
            'coin' => $market['base'],
        );
        if ($since !== null) {
            $method .= 'From';
            $request['from'] = intval($since / 1000);
        }
        $to = $this->safe_integer($params, 'to');
        if ($to !== null) {
            $method .= 'To';
        }
        $response = yield $this->$method (array_merge($request, $params));
        return $this->parse_trades($response, $market, $since, $limit);
    }

    public function parse_balance($response) {
        $data = $this->safe_value($response, 'response_data', array());
        $balances = $this->safe_value($data, 'balance', array());
        $result = array( 'info' => $response );
        $currencyIds = is_array($balances) ? array_keys($balances) : array();
        for ($i = 0; $i < count($currencyIds); $i++) {
            $currencyId = $currencyIds[$i];
            $code = $this->safe_currency_code($currencyId);
            if (is_array($balances) && array_key_exists($currencyId, $balances)) {
                $balance = $this->safe_value($balances, $currencyId, array());
                $account = $this->account();
                $account['free'] = $this->safe_string($balance, 'available');
                $account['total'] = $this->safe_string($balance, 'total');
                $result[$code] = $account;
            }
        }
        return $this->safe_balance($result);
    }

    public function fetch_balance($params = array ()) {
        yield $this->load_markets();
        $response = yield $this->privatePostGetAccountInfo ($params);
        return $this->parse_balance($response);
    }

    public function create_order($symbol, $type, $side, $amount, $price = null, $params = array ()) {
        yield $this->load_markets();
        $request = array(
            'coin_pair' => $this->market_id($symbol),
        );
        $method = $this->capitalize($side) . 'Order';
        if ($type === 'limit') {
            $method = 'privatePostPlace' . $method;
            $request['limit_price'] = $this->price_to_precision($symbol, $price);
            $request['quantity'] = $this->amount_to_precision($symbol, $amount);
        } else {
            $method = 'privatePostPlaceMarket' . $method;
            if ($side === 'buy') {
                if ($price === null) {
                    throw new InvalidOrder($this->id . ' createOrder() requires the $price argument with market buy orders to calculate total order cost ($amount to spend), where cost = $amount * $price-> Supply a $price argument to createOrder() call if you want the cost to be calculated for you from $price and amount');
                }
                $request['cost'] = $this->price_to_precision($symbol, $amount * $price);
            } else {
                $request['quantity'] = $this->amount_to_precision($symbol, $amount);
            }
        }
        $response = yield $this->$method (array_merge($request, $params));
        // TODO => replace this with a call to parseOrder for unification
        return array(
            'info' => $response,
            'id' => (string) $response['response_data']['order']['order_id'],
        );
    }

    public function cancel_order($id, $symbol = null, $params = array ()) {
        if ($symbol === null) {
            throw new ArgumentsRequired($this->id . ' cancelOrder () requires a $symbol argument');
        }
        yield $this->load_markets();
        $market = $this->market($symbol);
        $request = array(
            'coin_pair' => $market['id'],
            'order_id' => $id,
        );
        $response = yield $this->privatePostCancelOrder (array_merge($request, $params));
        //
        //     {
        //         response_data => {
        //             $order => array(
        //                 order_id => 2176769,
        //                 coin_pair => 'BRLBCH',
        //                 order_type => 2,
        //                 status => 3,
        //                 has_fills => false,
        //                 quantity => '0.10000000',
        //                 limit_price => '1996.15999',
        //                 executed_quantity => '0.00000000',
        //                 executed_price_avg => '0.00000',
        //                 fee => '0.00000000',
        //                 created_timestamp => '1536956488',
        //                 updated_timestamp => '1536956499',
        //                 operations => array()
        //             }
        //         ),
        //         status_code => 100,
        //         server_unix_timestamp => '1536956499'
        //     }
        //
        $responseData = $this->safe_value($response, 'response_data', array());
        $order = $this->safe_value($responseData, 'order', array());
        return $this->parse_order($order, $market);
    }

    public function parse_order_status($status) {
        $statuses = array(
            '2' => 'open',
            '3' => 'canceled',
            '4' => 'closed',
        );
        return $this->safe_string($statuses, $status, $status);
    }

    public function parse_order($order, $market = null) {
        //
        //     {
        //         "order_id" => 4,
        //         "coin_pair" => "BRLBTC",
        //         "order_type" => 1,
        //         "status" => 2,
        //         "has_fills" => true,
        //         "quantity" => "2.00000000",
        //         "limit_price" => "900.00000",
        //         "executed_quantity" => "1.00000000",
        //         "executed_price_avg" => "900.00000",
        //         "fee" => "0.00300000",
        //         "created_timestamp" => "1453838494",
        //         "updated_timestamp" => "1453838494",
        //         "operations" => array(
        //             array(
        //                 "operation_id" => 1,
        //                 "quantity" => "1.00000000",
        //                 "price" => "900.00000",
        //                 "fee_rate" => "0.30",
        //                 "executed_timestamp" => "1453838494",
        //             ),
        //         ),
        //     }
        //
        $id = $this->safe_string($order, 'order_id');
        $order_type = $this->safe_string($order, 'order_type');
        $side = null;
        if (is_array($order) && array_key_exists('order_type', $order)) {
            $side = ($order_type === '1') ? 'buy' : 'sell';
        }
        $status = $this->parse_order_status($this->safe_string($order, 'status'));
        $marketId = $this->safe_string($order, 'coin_pair');
        $market = $this->safe_market($marketId, $market);
        $timestamp = $this->safe_timestamp($order, 'created_timestamp');
        $fee = array(
            'cost' => $this->safe_string($order, 'fee'),
            'currency' => $market['quote'],
        );
        $price = $this->safe_string($order, 'limit_price');
        // $price = $this->safe_number($order, 'executed_price_avg', $price);
        $average = $this->safe_string($order, 'executed_price_avg');
        $amount = $this->safe_string($order, 'quantity');
        $filled = $this->safe_string($order, 'executed_quantity');
        $lastTradeTimestamp = $this->safe_timestamp($order, 'updated_timestamp');
        $rawTrades = $this->safe_value($order, 'operations', array());
        return $this->safe_order(array(
            'info' => $order,
            'id' => $id,
            'clientOrderId' => null,
            'timestamp' => $timestamp,
            'datetime' => $this->iso8601($timestamp),
            'lastTradeTimestamp' => $lastTradeTimestamp,
            'symbol' => $market['symbol'],
            'type' => 'limit',
            'timeInForce' => null,
            'postOnly' => null,
            'side' => $side,
            'price' => $price,
            'stopPrice' => null,
            'cost' => null,
            'average' => $average,
            'amount' => $amount,
            'filled' => $filled,
            'remaining' => null,
            'status' => $status,
            'fee' => $fee,
            'trades' => $rawTrades,
        ), $market);
    }

    public function fetch_order($id, $symbol = null, $params = array ()) {
        if ($symbol === null) {
            throw new ArgumentsRequired($this->id . ' fetchOrder () requires a $symbol argument');
        }
        yield $this->load_markets();
        $market = $this->market($symbol);
        $request = array(
            'coin_pair' => $market['id'],
            'order_id' => intval($id),
        );
        $response = yield $this->privatePostGetOrder (array_merge($request, $params));
        $responseData = $this->safe_value($response, 'response_data', array());
        $order = $this->safe_value($responseData, 'order');
        return $this->parse_order($order, $market);
    }

    public function withdraw($code, $amount, $address, $tag = null, $params = array ()) {
        list($tag, $params) = $this->handle_withdraw_tag_and_params($tag, $params);
        $this->check_address($address);
        yield $this->load_markets();
        $currency = $this->currency($code);
        $request = array(
            'coin' => $currency['id'],
            'quantity' => sprintf('%.10f', $amount),
            'address' => $address,
        );
        if ($code === 'BRL') {
            $account_ref = (is_array($params) && array_key_exists('account_ref', $params));
            if (!$account_ref) {
                throw new ArgumentsRequired($this->id . ' withdraw() requires $account_ref parameter to withdraw ' . $code);
            }
        } else if ($code !== 'LTC') {
            $tx_fee = (is_array($params) && array_key_exists('tx_fee', $params));
            if (!$tx_fee) {
                throw new ArgumentsRequired($this->id . ' withdraw() requires $tx_fee parameter to withdraw ' . $code);
            }
            if ($code === 'XRP') {
                if ($tag === null) {
                    if (!(is_array($params) && array_key_exists('destination_tag', $params))) {
                        throw new ArgumentsRequired($this->id . ' withdraw() requires a $tag argument or destination_tag parameter to withdraw ' . $code);
                    }
                } else {
                    $request['destination_tag'] = $tag;
                }
            }
        }
        $response = yield $this->privatePostWithdrawCoin (array_merge($request, $params));
        return array(
            'info' => $response,
            'id' => $response['response_data']['withdrawal']['id'],
        );
    }

    public function parse_ohlcv($ohlcv, $market = null) {
        return array(
            $this->safe_timestamp($ohlcv, 'timestamp'),
            $this->safe_number($ohlcv, 'open'),
            $this->safe_number($ohlcv, 'high'),
            $this->safe_number($ohlcv, 'low'),
            $this->safe_number($ohlcv, 'close'),
            $this->safe_number($ohlcv, 'volume'),
        );
    }

    public function fetch_ohlcv($symbol, $timeframe = '5m', $since = null, $limit = null, $params = array ()) {
        yield $this->load_markets();
        $market = $this->market($symbol);
        $request = array(
            'precision' => $this->timeframes[$timeframe],
            'coin' => strtolower($market['id']),
        );
        if ($limit !== null && $since !== null) {
            $request['from'] = intval($since / 1000);
            $request['to'] = $this->sum($request['from'], $limit * $this->parse_timeframe($timeframe));
        } else if ($since !== null) {
            $request['from'] = intval($since / 1000);
            $request['to'] = $this->sum($this->seconds(), 1);
        } else if ($limit !== null) {
            $request['to'] = $this->seconds();
            $request['from'] = $request['to'] - ($limit * $this->parse_timeframe($timeframe));
        }
        $response = yield $this->v4PublicGetCoinCandle (array_merge($request, $params));
        $candles = $this->safe_value($response, 'candles', array());
        return $this->parse_ohlcvs($candles, $market, $timeframe, $since, $limit);
    }

    public function fetch_orders($symbol = null, $since = null, $limit = null, $params = array ()) {
        if ($symbol === null) {
            throw new ArgumentsRequired($this->id . ' fetchOrders () requires a $symbol argument');
        }
        yield $this->load_markets();
        $market = $this->market($symbol);
        $request = array(
            'coin_pair' => $market['id'],
        );
        $response = yield $this->privatePostListOrders (array_merge($request, $params));
        $responseData = $this->safe_value($response, 'response_data', array());
        $orders = $this->safe_value($responseData, 'orders', array());
        return $this->parse_orders($orders, $market, $since, $limit);
    }

    public function fetch_open_orders($symbol = null, $since = null, $limit = null, $params = array ()) {
        if ($symbol === null) {
            throw new ArgumentsRequired($this->id . ' fetchOpenOrders () requires a $symbol argument');
        }
        yield $this->load_markets();
        $market = $this->market($symbol);
        $request = array(
            'coin_pair' => $market['id'],
            'status_list' => '[2]', // open only
        );
        $response = yield $this->privatePostListOrders (array_merge($request, $params));
        $responseData = $this->safe_value($response, 'response_data', array());
        $orders = $this->safe_value($responseData, 'orders', array());
        return $this->parse_orders($orders, $market, $since, $limit);
    }

    public function fetch_my_trades($symbol = null, $since = null, $limit = null, $params = array ()) {
        if ($symbol === null) {
            throw new ArgumentsRequired($this->id . ' fetchMyTrades () requires a $symbol argument');
        }
        yield $this->load_markets();
        $market = $this->market($symbol);
        $request = array(
            'coin_pair' => $market['id'],
            'has_fills' => true,
        );
        $response = yield $this->privatePostListOrders (array_merge($request, $params));
        $responseData = $this->safe_value($response, 'response_data', array());
        $ordersRaw = $this->safe_value($responseData, 'orders', array());
        $orders = $this->parse_orders($ordersRaw, $market, $since, $limit);
        $trades = $this->orders_to_trades($orders);
        return $this->filter_by_symbol_since_limit($trades, $symbol, $since, $limit);
    }

    public function orders_to_trades($orders) {
        $result = array();
        for ($i = 0; $i < count($orders); $i++) {
            $trades = $this->safe_value($orders[$i], 'trades', array());
            for ($y = 0; $y < count($trades); $y++) {
                $result[] = $trades[$y];
            }
        }
        return $result;
    }

    public function sign($path, $api = 'public', $method = 'GET', $params = array (), $headers = null, $body = null) {
        $url = $this->urls['api'][$api] . '/';
        $query = $this->omit($params, $this->extract_params($path));
        if ($api === 'public' || ($api === 'v4Public')) {
            $url .= $this->implode_params($path, $params);
            if ($query) {
                $url .= '?' . $this->urlencode($query);
            }
        } else {
            $this->check_required_credentials();
            $url .= $this->version . '/';
            $nonce = $this->nonce();
            $body = $this->urlencode(array_merge(array(
                'tapi_method' => $path,
                'tapi_nonce' => $nonce,
            ), $params));
            $auth = '/tapi/' . $this->version . '/' . '?' . $body;
            $headers = array(
                'Content-Type' => 'application/x-www-form-urlencoded',
                'TAPI-ID' => $this->apiKey,
                'TAPI-MAC' => $this->hmac($this->encode($auth), $this->encode($this->secret), 'sha512'),
            );
        }
        return array( 'url' => $url, 'method' => $method, 'body' => $body, 'headers' => $headers );
    }

    public function handle_errors($httpCode, $reason, $url, $method, $headers, $body, $response, $requestHeaders, $requestBody) {
        if ($response === null) {
            return;
        }
        //
        // todo add a unified standard handleErrors with $this->exceptions in describe()
        //
        //     array("status":503,"message":"Maintenancing, try again later","result":null)
        //
        $errorMessage = $this->safe_value($response, 'error_message');
        if ($errorMessage !== null) {
            throw new ExchangeError($this->id . ' ' . $this->json($response));
        }
    }
}