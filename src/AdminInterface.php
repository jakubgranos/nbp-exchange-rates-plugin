<?php
namespace ApiNbpRatesPlugin;

/**
 * Displaying the exchange rates in the admin interface
 */
class AdminInterface {
    private $apiClient;

    public function __construct() {
        $this->apiClient = new NbpApiClient();
        add_action('after-post_tag-table', [$this, 'displayExchangeRates']);
    }

    public function displayExchangeRates() {
        // Retrieve the current screen object
        $screen = get_current_screen();
        $isEditTagsPage = $screen->id === 'edit-post_tag';

        // Check if we are on the tags admin page
        if (!$isEditTagsPage) {
            return;
        }

        $goldPrice = $this->apiClient->fetchGoldPrice();
        $currencyRates = $this->apiClient->fetchCurrencyRates();

        $goldPrice = apply_filters('nbp_gold_price', $goldPrice);
        $currencyRates = apply_filters('nbp_currency_rates', $currencyRates);

        // Generate the HTML content
        echo $this->generateExchangeRatesHtml($goldPrice, $currencyRates);
    }

    /**
     * Just to have a clean, readable code, generate the HTML content in a separate method.
     */
    private function generateExchangeRatesHtml($goldPrice, $currencyRates) {
        /**
         * If the gold price or currency rates are empty, don't display anything.
         */
        if (empty($goldPrice) || empty($currencyRates)) {
            return;
        }
        
        ob_start();
        ?>
        <div class="nbp-exchange-rates">
            <h3>Current Prices</h3>
            <?php if (isset($goldPrice[0]['cena'])): ?>
                <p>Gold Price: <?php echo esc_html($goldPrice[0]['cena']); ?></p>
            <?php endif; ?>

            <?php foreach ($currencyRates as $currency => $rate): ?>
                <?php if (isset($rate['rates'][0]['mid'])): ?>
                    <p>Average exchange rate <?php echo strtoupper($currency); ?>: <?php echo esc_html($rate['rates'][0]['mid']); ?></p>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
        <?php
        return ob_get_clean();
    }
}
