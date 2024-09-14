<?php
/**
 * Plugin Name: API NBP Rates Plugin
 * Description: A plugin to fetch and display NBP rates.
 * Version: 1.0.0
 * Author: Jakub Granos
 * Author URI: mailto:jakubgranos@gmail.com
 */

// Include the Composer autoload file
require_once __DIR__ . '/vendor/autoload.php';

use ApiNbpRatesPlugin\AdminInterface;

/**
 * Initialize the plugin functions
 */
function nbp_exchange_rates_init() {
    new AdminInterface();
}

add_action('plugins_loaded', 'nbp_exchange_rates_init');
