<?php
/**
 * Plugin Name: API NBP Rates Plugin
 * Description: A plugin to fetch and display NBP rates.
 * Version: 1.0.0
 * Author: Jakub Granos
 * Author URI: mailto:jakubgranos@gmail.com
 */

// Include the Composer autoload file
$autoload_path = __DIR__ . '/vendor/autoload.php';

/**
 * If statement for avoiding errors when the autoload file is missing and plugin is activated
 */
if (file_exists($autoload_path)) {
    require_once $autoload_path;
} else {
    // Display an admin notice if the autoload file is missing
    add_action('admin_notices', function() {
        ?>
        <div class="notice notice-error">
            <p><?php _e('API NBP Rates Plugin: The Composer autoload file is missing. Please run "composer install" in the plugin directory.', 'api-nbp-rates-plugin'); ?></p>
        </div>
        <?php
    });
    return;
}
use ApiNbpRatesPlugin\AdminInterface;

/**
 * Initialize the plugin functions
 */
function nbp_exchange_rates_init() {
    new AdminInterface();
}

add_action('plugins_loaded', 'nbp_exchange_rates_init');
