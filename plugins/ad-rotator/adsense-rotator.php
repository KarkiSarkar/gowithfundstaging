<?php
/*
Plugin Name: AdSense Rotator
Description: Rotates Google AdSense ad codes and generates shortcode.
Version: 3.0
Author: Nydoz Team
*/

// Add settings menu
add_action('admin_menu', 'adsense_rotator_menu');
function adsense_rotator_menu() {
    add_options_page('AdSense Rotator Settings', 'AdSense Rotator', 'manage_options', 'adsense-rotator', 'adsense_rotator_settings_page');
}

// Register settings
add_action('admin_init', 'adsense_rotator_settings');
function adsense_rotator_settings() {
    register_setting('adsense-rotator-settings-group', 'adsense_rotator_ad_units');
}

// Settings page HTML
function adsense_rotator_settings_page() {
    ?>
    <div class="wrap">
        <h1>AdSense Rotator Settings</h1>
        <form method="post" action="options.php">
            <?php settings_fields('adsense-rotator-settings-group'); ?>
            <?php do_settings_sections('adsense-rotator-settings-group'); ?>

            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Ad Units</th>
                    <td>
                        <textarea name="adsense_rotator_ad_units" rows="10" cols="50" class="large-text code"><?php echo esc_textarea(get_option('adsense_rotator_ad_units')); ?></textarea>
                        <p>Enter the ad units in JSON format. Example:
                            <pre>
[
    {
        "client_id": "ca-pub-xxxxxxx",
        "name": "Sponsered1"
    },
    {
        "client_id": "ca-pub-yyyyyyyy",
        "name": "Sponsered2"
    },
    {
        "client_id": "ca-pub-zzzzzzzz",
        "name": "Sponsered3"
    }
]
                            </pre>
                        </p>
                    </td>
                </tr>
            </table>

            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

// Function to get rotated AdSense ad units from the database
function get_rotated_ad_units() {
    $ad_units = get_option('adsense_rotator_ad_units');
    if ($ad_units) {
        return json_decode($ad_units, true);
    }
    return array();
}

// Function to rotate AdSense ad units with names
function rotate_named_adsense_ads() {
    // if (!isset($_SESSION)) {
    //     session_start();
    // }

    // Check if the session variable is set
    if (!isset($_SESSION['selected_ad_unit'])) {
        // Randomly select an ad unit
        $_SESSION['selected_ad_unit'] = array_rand(get_rotated_ad_units());
    }

    // Get the selected ad unit
    $ad_units = get_rotated_ad_units();
    if (empty($ad_units)) {
        return;
    }
    $selected_ad = $ad_units[$_SESSION['selected_ad_unit']];

    // Output the ad unit
    if (!is_user_logged_in()) {
        ?>
        <p><?php echo esc_attr($selected_ad['client_id']); ?></p>
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=<?php echo esc_attr($selected_ad['client_id']); ?>&amp;cachebuster=<?php echo time(); ?>" crossorigin="anonymous"></script>
        <?php
    }
}

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

function insert_ads_after_paragraph($content) {
    // Check if it's a single post page
    if (is_single()) {
        // Split content into paragraphs
        $paragraphs = explode("</p>", $content);

        // Insert shortcode after every second paragraph
        for ($i = 2; $i < count($paragraphs); $i += 3) {
            $paragraphs[$i] .= '[rotate_named_adsense_ads]';
        }

        // Join paragraphs back together
        $content = implode("</p>", $paragraphs);
    }

    return $content;
}
add_filter('the_content', 'insert_ads_after_paragraph');

// Function to insert the AdSense ad shortcode into the header
function insert_ads_in_header() {
    echo do_shortcode('[rotate_named_adsense_ads]');
}
add_action('wp_head', 'insert_ads_in_header');

// Shortcode to insert AdSense ad unit
function rotate_named_adsense_ads_shortcode() {
    ob_start(); // Start output buffering
    rotate_named_adsense_ads(); // Rotate ad units
    return ob_get_clean(); // Return buffered content
}
add_shortcode('rotate_named_adsense_ads', 'rotate_named_adsense_ads_shortcode');
