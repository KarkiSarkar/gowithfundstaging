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
    add_options_page('ads.txt Editor', 'ads.txt Editor', 'manage_options', 'ads-txt-editor', 'ads_txt_editor_page');
}

// Register settings
add_action('admin_init', 'adsense_rotator_settings');
function adsense_rotator_settings() {
    register_setting('adsense-rotator-settings-group', 'adsense_rotator_ad_units', 'sanitize_ad_units');
}

// Sanitize the input
function sanitize_ad_units($input) {
    if (is_array($input)) {
        foreach ($input as $key => $value) {
            $input[$key] = sanitize_text_field($value);
        }
    }
    return $input;
}

// Settings page HTML
function adsense_rotator_settings_page() {
    ?>
    <div class="wrap">
        <h1>AdSense Rotator Settings</h1>
        <form method="post" action="options.php">
            <?php settings_fields('adsense-rotator-settings-group'); ?>
            <?php do_settings_sections('adsense-rotator-settings-group'); ?>

            <table class="form-table" id="adsense-rotator-ad-units">
                <tr valign="top">
                    <th scope="row">Ad Units</th>
                    <td id="ad-units-container">
                        <?php
                        $ad_units = get_option('adsense_rotator_ad_units', array());
                        if (!is_array($ad_units)) {
                            $ad_units = array();
                        }
                        if (!empty($ad_units)) {
                            foreach ($ad_units as $index => $ad_unit) {
                                ?>
                                <div class="ad-unit">
                                    <input type="text" name="adsense_rotator_ad_units[]" value="<?php echo esc_attr($ad_unit); ?>" class="large-text" />
                                    <button type="button" class="button remove-ad-unit">Remove</button>
                                </div>
                                <?php
                            }
                        } else {
                            ?>
                            <div class="ad-unit">
                                <input type="text" name="adsense_rotator_ad_units[]" value="" class="large-text" />
                                <button type="button" class="button remove-ad-unit">Remove</button>
                            </div>
                            <?php
                        }
                        ?>
                    </td>
                </tr>
            </table>

            <button type="button" class="button" id="add-ad-unit">Add Ad Unit</button>

            <?php submit_button(); ?>
        </form>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        var container = document.getElementById('ad-units-container');
        var addButton = document.getElementById('add-ad-unit');

        addButton.addEventListener('click', function () {
            var div = document.createElement('div');
            div.className = 'ad-unit';
            div.innerHTML = '<input type="text" name="adsense_rotator_ad_units[]" value="" class="large-text" /> <button type="button" class="button remove-ad-unit">Remove</button>';
            container.appendChild(div);
        });

        container.addEventListener('click', function (e) {
            if (e.target && e.target.classList.contains('remove-ad-unit')) {
                e.target.parentElement.remove();
            }
        });
    });
    </script>
    <?php
}

// Function to get the ad units from the database
function get_rotated_ad_units() {
    $ad_units = get_option('adsense_rotator_ad_units');
    if (!is_array($ad_units)) {
        $ad_units = array();
    }
    return $ad_units;
}

// Function to rotate AdSense ad units
function rotate_named_adsense_ads() {
    $ad_units = get_rotated_ad_units();

    // Check if there are any ad units
    if (empty($ad_units)) {
        return; // No ad units to display
    }

    // Randomly select an ad unit
    $selected_ad = $ad_units[array_rand($ad_units)];

    // Output the ad unit
    if (!is_user_logged_in()) {
        ?>
        <p><?php echo esc_attr($selected_ad); ?></p>
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-<?php echo esc_attr($selected_ad); ?>&amp;cachebuster=<?php echo time(); ?>" crossorigin="anonymous"></script>
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

        // Insert shortcode after every third paragraph
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

// Function to read ads.txt content
function read_ads_txt() {
    $file = ABSPATH . 'ads.txt';
    if (file_exists($file)) {
        return file_get_contents($file);
    }
    return '';
}

// Function to write to ads.txt
function write_ads_txt($content) {
    $file = ABSPATH . 'ads.txt';
    file_put_contents($file, $content);
}

// ads.txt editor page
function ads_txt_editor_page() {
    if (isset($_POST['ads_txt_content'])) {
        check_admin_referer('save_ads_txt', 'ads_txt_nonce');
        write_ads_txt(wp_unslash($_POST['ads_txt_content']));
        echo '<div class="updated"><p>ads.txt updated successfully.</p></div>';
    }
    $ads_txt_content = esc_textarea(read_ads_txt());
    ?>
    <div class="wrap">
        <h1>ads.txt Editor</h1>
        <form method="post" action="">
            <?php wp_nonce_field('save_ads_txt', 'ads_txt_nonce'); ?>
            <textarea name="ads_txt_content" rows="20" cols="100" class="large-text"><?php echo $ads_txt_content; ?></textarea>
            <?php submit_button('Save ads.txt'); ?>
        </form>
    </div>
    <?php
}
