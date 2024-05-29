<?php
/*
Plugin Name: AdSense Rotator
Description: Rotates Google AdSense ad codes and generates shortcode.
Version: 3.0
Author: Nydoz Team
*/

// Function to add in settings menu
add_action('admin_menu', 'adsense_rotator_menu');
function adsense_rotator_menu() {
    add_options_page('Adsense Rotator Settings', 'AdSense Rotator', 'manage_options', 'adsense-rotator', 'adsense_rotator_settings_page');
    add_options_page('ads.txt Editor', 'ads.txt Rotator', 'manage_options', 'ads-txt-editor', 'ads_txt_editor_page');
}

// Function to register settings in wordpress dashboard
add_action('admin_init', 'adsense_rotator_settings');
function adsense_rotator_settings() {
    register_setting('adsense-rotator-settings-group', 'adsense_rotator_ad_units', 'sanitize_ad_units');
    register_setting('adsense-rotator-settings-group', 'adsense_rotator_slot_ids', 'sanitize_ad_units');
}

// Function to sanitize the input in the plugin
function sanitize_ad_units($input){
    if (is_array($input)) {
        foreach($input as $key => $value){
            $input[$key] = sanitize_text_field($value);
        }
    }
    return $input;
}

// Function to sanitize the slot IDs input
function sanitize_slot_ids($input){
    if(is_array($input)){
        foreach($input as $key => $value){
            $input[$key] = sanitize_text_field($value);
        }
    }
    return $input;
}

// Settings page HTML
function adsense_rotator_settings_page() {
    ?>
    <style>
        .ad-rotator-wrap{
            background-color : #95dbe5;
            padding: 2rem;
        }
        .ad-rotator-header{
            font-size: 32px;
        }
        .ad-unit{
            margin-bottom: 20px;
            display: flex;
            justify-content: 
        }
        .ad-unit > p{
            font-weight: 700;
            padding-right: 10px;
        }
    </style>
    <div class="ad-rotator-wrap">
        <h1 class="ad-rotator-header">AdSense ID Rotator Settings</h1>
        <form method="post" action="options.php">
            <?php settings_fields('adsense-rotator-settings-group'); ?>
            <?php do_settings_sections('adsense-rotator-settings-group'); ?>

            <table class="form-table" id="adsense-rotator-ad-units">
                <tr valign="top">
                    <th scope="row">Ad Units</th>
                    <td id="ad-units-container">
                        <?php
                        $ad_units = get_option('adsense_rotator_ad_units', array());
                        $slot_ids = get_option('adsense_rotator_slot_ids', array());
                        if (!is_array($ad_units)) {
                            $ad_units = array();
                        }
                        $counter = 1;
                        foreach ($ad_units as $index => $ad_unit) {
                            ?>
                            <div class="ad-unit">
                                <p><?php echo $counter; ?></p>
                                <div>
                                    <input type="text" name="adsense_rotator_ad_units[]" value="<?php echo esc_attr($ad_unit); ?>" class="large-text" placeholder="Ad Unit ID" />
                                    <input type="text" name="adsense_rotator_slot_ids[]" value="<?php echo isset($slot_ids[$index]) ? esc_attr($slot_ids[$index]) : ''; ?>" class="large-text" placeholder="Slot ID" />
                                    <button type="button" class="button remove-ad-unit">Remove</button>
                                </div>
                            </div>
                            <?php
                            $counter++;
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
            div.innerHTML = '<input type="text" name="adsense_rotator_ad_units[]" value="" class="large-text" placeholder="Ad Unit ID" />' +
                        '<input type="text" name="adsense_rotator_slot_ids[]" value="" class="large-text" placeholder="Slot ID" />' +
                        '<button type="button" class="button remove-ad-unit">Remove</button>';
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

// Function to get the ad units and slot IDs from the database
function get_rotated_ad_units_and_slots() {
    $ad_units = get_option('adsense_rotator_ad_units', array());
    $slot_ids = get_option('adsense_rotator_slot_ids', array());
    if (!is_array($ad_units)) {
        $ad_units = array();
    }
    if (!is_array($slot_ids)) {
        $slot_ids = array();
    }
    return array($ad_units, $slot_ids);
}

// Function to select a random ad unit ID and store it in a transient
function get_selected_ad_unit_and_slot() {
    if (false === ($selected_ad = get_transient('selected_adsense_ad_unit'))) {
        list($ad_units, $slot_ids) = get_rotated_ad_units_and_slots();
        if (!empty($ad_units)) {
            $index = array_rand($ad_units);
            $selected_ad = array('ad_unit' => $ad_units[$index], 'slot_id' => $slot_ids[$index]);
            set_transient('selected_adsense_ad_unit', $selected_ad, 60); // Store for 1 minute
        }
    }
    return $selected_ad;
}


// Function to clear the transient on page refresh
function clear_ad_unit_transient() {
    delete_transient('selected_adsense_ad_unit');
}
add_action('wp_head', 'clear_ad_unit_transient');

// Function to display the selected AdSense ad unit
function display_adsense_ad_unit() {
    $selected_ad = get_selected_ad_unit_and_slot();

    if ($selected_ad && !is_user_logged_in()) {
        ?>
        <p><?php echo esc_attr($selected_ad['ad_unit']); ?><?php echo esc_attr($selected_ad['slot_id']); ?></p>
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-<?php echo esc_attr($selected_ad['ad_unit']); ?>&amp;slot=<?php echo esc_attr($selected_ad['slot_id']); ?>&amp;cachebuster=<?php echo time(); ?>" crossorigin="anonymous"></script>
        <?php
    }
}

// Insert ads after paragraphs in single posts
function insert_ads_after_paragraph($content) {
    if (is_single()) {
        $paragraphs = explode("</p>", $content);
        for ($i = 2; $i < count($paragraphs); $i += 3) {
            $paragraphs[$i] .= '[rotate_named_adsense_ads]';
        }
        $content = implode("</p>", $paragraphs);
    }
    return $content;
}
add_filter('the_content', 'insert_ads_after_paragraph');

// Insert the AdSense ad shortcode into the header
function insert_ads_in_header() {
    echo do_shortcode('[rotate_named_adsense_ads]');
}
add_action('wp_head', 'insert_ads_in_header');

// Shortcode to insert AdSense ad unit
function rotate_named_adsense_ads_shortcode() {
    ob_start();
    display_adsense_ad_unit();
    return ob_get_clean();
}
add_shortcode('rotate_named_adsense_ads', 'rotate_named_adsense_ads_shortcode');

// Function to read ads.txt content
function read_ads_txt() {
    $file = ABSPATH . 'ads.txt';
    return file_exists($file) ? file_get_contents($file) : '';
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
?>
