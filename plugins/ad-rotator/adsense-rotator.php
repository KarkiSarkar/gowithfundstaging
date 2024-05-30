<?php
/*
Plugin Name: AdSense Rotator
Description: Rotates Google AdSense ad codes and generates shortcode.
Version: 3.0
Author: Nydoz Team
*/

// Include necessary files
include plugin_dir_path(__FILE__) . 'includes/settings.php';
include plugin_dir_path(__FILE__) . 'includes/ad-functions.php';
include plugin_dir_path(__FILE__) . 'admin/settings-page.php';
include plugin_dir_path(__FILE__) . 'admin/ads-txt-editor.php';

function adsense_rotator_enqueue_style(){
    wp_enqueue_style('adsense-rotator-styles', plugin_dir_url(__FILE__) . 'includes/assets/css/styles.css');
    wp_enqueue_script('adsense-rotator-script', plugin_dir_url(__FILE__) . 'includes/assets/js/script.js');
    // wp_enqueue_script('adsense-rotator-form-script', plugin_dir_url(__FILE__) . 'includes/assets/js/form-script.js');
}
add_action('admin_enqueue_scripts', 'adsense_rotator_enqueue_style');
// Function to clear the transient on page refresh
function clear_ad_unit_transient() {
    delete_transient('selected_adsense_ad_unit');
}
add_action('wp_head', 'clear_ad_unit_transient');

// Insert the AdSense ad shortcode into the header
function insert_ads_in_header() {
    echo do_shortcode('[rotate_named_adsense_ads]');
    if ($display_slot_id) {
        echo do_shortcode('[adsense_ad_with_slot_id]');
    }
}
add_action('wp_head', 'insert_ads_in_header');
?>
