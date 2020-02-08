# ezdefi-php

Offical PHP SDK for interacting with ezDeFi API.

## Installation

You can install the package using [Composer]() package manager. You can install it by running this command in your project root:

```sh
composer require ezdefi/ezdefi-php
```

This libray uses [HTTPlug]() as HTTP client. Therefore, you need to provide it with an adapters [in Packagist](https://packagist.org/providers/php-http/client-implementation)

We also follow [PSR-7](https://www.php-fig.org/psr/psr-7/), [PSR-17](https://www.php-fig.org/psr/psr-17/) and [PSR-18](https://www.php-fig.org/psr/psr-18/) standards for HTTP messaging. So you need to install an HTTP client following those standard.

## Client

Initialize your client using your API key and base API url:

```php
use Ezdefi\Client;

$client = new Client('your-api-key', 'base-url');
```

## Payment

```php
/** Create payment */
$client->payment->createPayment([
    'uoid' => 1,
    'to' => 'receive wallet address',
    'value' => 1.00,
    'currency' => 'usd:btc',
    'callback' => 'http://foo.bar/callback',
    'amountId' => true
]);

/** Get payment detail by uoid and merchantId(merchant side) or paymentid */
$client->payment->getPaymentDetail([
    'paymentid' => 'paymentid', // payment id, which received after created                           
    'uoid' => 'uoid', // unique order id (merchant side)
    'userid' => 'userid' // merchant id
]);

/** Get payment list */
$client->payment->getPaymentList([
    'skip' => 10, // skip first found payments(default 0)
    'limit' => 15, // limit of searching result
    'ucid' => 1, // unique customer id(merchant side)
    'to' => 'wallet address', // received wallet address
    'chain' => 'value', // chain keyword (_id, name, address ...)
    'token' => 'btc', // token keyword (_id, name, address ...)
    'status' => 'PENDING' // payment status. Available values : EXPIRED, PENDING, DONE
]);

/** Get tx list of a payment */
$client->payment->getPaymentTxList([
    'paymentid' => 'paymentid',
    'skip' => 10,
    'limit' => 15,
]);
```

## Token

```php
/** Get token list */
$client->token->getTokenList();

/** Get token detail by ID */
$client->token->getTokenDetail('_id');

/** Get exchange rate between fiat and token */
$client->token->getTokenExchange('usd', 'btc');

/** Get exchange rates in bulk */
$client->token->getTokenExchanges(1.00, 'usd', ['btc', 'eth']);
```

## Chain

```php
/** Get chain list */
$client->chain->getChainList();

/** Get chain detail by keyword */
$client->chain->getChainDetail('keyword');
```

## Users

```php
/** Get user detail */
$client->user->getUserDetail();
```

## Transaction

```php
/** Get transaction detail */
$client->transaction->getTransactionDetail('transaction id');
```