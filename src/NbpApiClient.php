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
        $response = wp_remote_get($this->baseUrl . 'cenyzlota');
        
        return $this->parseResponse($response);
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
            $response = wp_remote_get($this->baseUrl . "exchangerates/rates/a/{$currency}/");

            /**
             * If the response is an error, we set the rate to null and continue to the next currency.
             */
            if(is_wp_error($response)) {
                $rates[$currency] = null;
                continue;
            }

            $rates[$currency] = $this->parseResponse($response);
        }

        return $rates;
    }

    /**
     * Parses the response from the API.
     */
    private function parseResponse($response) {
        if (is_wp_error($response)) {
            return null;
        }
        
        $body = wp_remote_retrieve_body($response);
        return json_decode($body, true);
    }
}
