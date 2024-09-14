<?php
namespace ApiNbpRatesPlugin;

/**
 * Fetching data to get gold price and currency rates
 */
class NbpApiClient {
    private $baseUrl = 'http://api.nbp.pl/api/';

    /**
     * Fetches the current gold price from the NBP API.
     * 
     * @return array|null The parsed response from the API, or null if an error occurred.
     */
    public function fetchGoldPrice() {
        return $this->parseResponse(\wp_remote_get($this->baseUrl . 'cenyzlota'));
    }

    /**
     * Fetches the current currency rates for EUR, GBP, and USD from the NBP API.
     * 
     * @return array An associative array of currency rates.
     */
    public function fetchCurrencyRates() {
        $currencies = ['eur', 'gbp', 'usd'];
        $rates = [];

        foreach ($currencies as $currency) {
            $response = \wp_remote_get($this->baseUrl . "exchangerates/rates/a/{$currency}/");
            $rates[$currency] = \is_wp_error($response) ? null : $this->parseResponse($response);
        }

        return $rates;
    }

    /**
     * Parses the response from the API.
     */
    private function parseResponse($response) {
        return \is_wp_error($response) ? null : json_decode(\wp_remote_retrieve_body($response), true);
    }
}
