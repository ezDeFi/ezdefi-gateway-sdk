# ezDeFi PHP Client

Offical ezDeFi PHP SDK. This SDK contains methods for easily interacting with ezDeFi API.

## Installation

This library uses [HTTPlug](http://httplug.io/) to decouple from any HTTP messaging client. This mean you're free to choose any [PSR-7 implementation](https://packagist.org/providers/psr/http-message-implementation) and [HTTP client](https://packagist.org/providers/php-http/client-implementation) you prefer.

If you just want to get started quickly you should run the following command:

```sh
composer require ezdefi/ezdefi-php php-http/curl-client nyholm/psr7
```

## Usage

To get started, you just need to create an instance of the client and use its method to get data you want.

```php
require_once __DIR__ . '/vendor/autoload.php';

use Ezdefi\Client;

$client = new Client('your-api-key');
```

## Payment

```php
/** Create new payment */
$client->payment->createPayment([
    'uoid' => 1,
    'to' => 'wallet_address',
    'value' => 1.00,
    'currency' => 'usd:btc',
    'callback' => 'http://foo.bar/callback',
    'amountId' => true
]);

/** Get payment detail by paymentid */
$client->payment->getPaymentDetail('payment_id');

/** Get payment list */
$client->payment->getPaymentList([
    'skip' => 10,
    'limit' => 15,
    'ucid' => 1,
    'to' => 'wallet_address',
    'chain' => 'value',
    'token' => 'btc',
    'status' => 'PENDING' // payment status. Available values : EXPIRED, PENDING, DONE
]);

/** Get tx list of a payment */
$client->payment->getPaymentTxList('payment_id');
```

## Token

```php
/** Get token list */
$client->token->getTokenList([
    'skip' => 5,
    'limit' => 10,
    'keyword' => 'b',
    'sort' => 'name'
]);

/** Get token detail by ID */
$client->token->getTokenDetail('token_id');

/** Get exchange rate between fiat and token */
$client->token->getTokenExchange('usd', 'btc');

/** Get exchange rates */
$client->token->getTokenExchanges(1.00, 'usd', ['btc', 'eth']);
```

## Chain

```php
/** Get chain list */
$client->chain->getChainList();
```

## User

```php
/** Get user detail */
$client->user->getUserDetail();
```

## Transaction

```php
/** Get transaction detail by transaction id */
$client->transaction->getTransactionDetail('transaction_id');
```