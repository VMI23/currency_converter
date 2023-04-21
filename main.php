<?php

declare(strict_types=1);

use App\CurrencyApiClient;
use GuzzleHttp\Client;

require "vendor/autoload.php";

$apiClient = new CurrencyApiClient();

$currency = readline("Enter currency to convert to: ");
$amount = (float)readline("Enter amount to convert to {$currency}: ");




echo PHP_EOL;

echo $amount." EUR to ". $currency. " : " .$apiClient->convert($amount,$currency);



