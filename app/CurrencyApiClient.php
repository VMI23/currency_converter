<?php

declare(strict_types=1);

namespace App;

use GuzzleHttp\Client;
use App\Currency;

class CurrencyApiClient
{
    private Client $client;

    private array $currencies;

    /**
     * @param Client $client
     */
    public function __construct()
    {
        $this->client = new Client();
    }

    public function convert(float $amount, string $toCurrency): float
    {
        $this->fetch();

        /**@var Currency $currency */

        $currency = $this->currencies[$toCurrency];

        if ($currency == null) {
            return 0;
        }

        return $amount * $currency->getValue();
    }

    public function fetch(): void
    {
        $response = $this->client->request('GET', 'https://www.latvijasbanka.lv/vk/ecb.xml');

        $records = simplexml_load_string($response->getBody()->getContents());

        foreach ($records->Currencies->Currency as $record)
        {
            $this->currencies[(string)$record->ID] = new Currency((string)$record->ID, (float)$record->Rate);
        }
    }


}