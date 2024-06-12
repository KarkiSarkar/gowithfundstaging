<?php
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


// // Function to select a random ad unit ID and store it in a transient
// function get_selected_ad_unit_and_slot() {
//     if (false === ($selected_ad = get_transient('selected_adsense_ad_unit'))) {
//         list($ad_units, $slot_ids) = get_rotated_ad_units_and_slots();
//         if (!empty($ad_units)) {
//             $index = array_rand($ad_units);
//             $selected_ad = array('ad_unit' => $ad_units[$index], 'slot_id' => $slot_ids[$index]);
//             set_transient('selected_adsense_ad_unit', $selected_ad, 60); // Store for 1 minute
//         }
//     }
//     return $selected_ad;
// }




// Function to select a random ad unit ID and store it in a transient
function get_selected_ad_unit_and_slot() {
    // Check if a selected ad is already cached
    if (false === ($selected_ad = get_transient('selected_adsense_ad_unit'))) {
        // Retrieve ad units and slot IDs
        list($ad_units, $slot_ids) = get_rotated_ad_units_and_slots();

        // Check if there are available ad units
        if (!empty($ad_units)) {
            // Retrieve the current index from a transient
            $current_index = get_transient('selected_adsense_ad_index');
            if ($current_index === false) {
                $current_index = -1; // Initialize to -1 to start from the first ad unit
            }

            // Increment the index
            $current_index = ($current_index + 1) % count($ad_units);

            // Select the ad unit and slot based on the updated index
            $selected_ad = array('ad_unit' => $ad_units[$current_index], 'slot_id' => $slot_ids[$current_index]);

            // Cache the selected ad unit and slot
            set_transient('selected_adsense_ad_unit', $selected_ad, 30000); // Store for 1 minute
            // Store the updated index in a transient for 1 minute
            set_transient('selected_adsense_ad_index', $current_index, 30000);
        } else {
            $selected_ad = null;
        }
    }

    return $selected_ad;
}







// Function to display the selected AdSense ad unit
function display_adsense_ad_unit() {
    $selected_ad = get_selected_ad_unit_and_slot();
    
    if ($selected_ad && !is_user_logged_in()) {
        ?>
        <p><?php echo esc_attr($selected_ad['ad_unit']); ?><div class="slot-id-input"></div></p>
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-<?php echo esc_attr($selected_ad['ad_unit']); ?>&amp;cachebuster=<?php echo time(); ?>" crossorigin="anonymous"></script>
        <?php
    }
}
$display_slot_id = get_option('display_slot_id_enabled');

// Function to display the selected AdSense ad unit with slot ID
function display_adsense_ad_unit_with_slot_id() {
    // Check if the display_slot_id option is enabled
    if (!get_option('display_slot_id_enabled')) {
        // If the option is disabled, do not display anything
        return '';
    }
    
    $selected_ad = get_selected_ad_unit_and_slot();
    if ($selected_ad && !is_user_logged_in()) {
        ob_start();
        ?>
        <p>
            <?php echo esc_attr($selected_ad['ad_unit']); ?>
            <div class="slot-id-input"><?php echo esc_attr($selected_ad['slot_id']); ?></div>
            <img width="300" src="https://images.unsplash.com/photo-1631270315847-f418bde47ca6?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"/>
        </p>
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-<?php echo esc_attr($selected_ad['ad_unit']); ?>"
            crossorigin="anonymous"></script>
        <ins class="adsbygoogle"
            style="display:block"
            data-ad-client="ca-pub-<?php echo esc_attr($selected_ad['ad_unit']); ?>"
            data-ad-slot="<?php echo esc_attr($selected_ad['slot_id']); ?>"
            data-ad-format="auto"
            data-full-width-responsive="true"></ins>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
        <?php
        return ob_get_clean();
    }
    return '';
}

// Register the shortcode for the new function
function register_adsense_shortcodes() {
    add_shortcode('adsense_ad_with_slot_id', 'display_adsense_ad_unit_with_slot_id');
}
add_action('init', 'register_adsense_shortcodes');



// Insert ads before the post content
function insert_ads_before_post($content) {
    $ads_before_enabled = get_option('insert_ads_before_post_enabled'); // Get the status of the checkbox
    if (is_single() && $ads_before_enabled) { // Check if it's a single post and ads insertion is enabled
        $content = '[adsense_ad_with_slot_id]' . $content;
    }
    return $content;
}
add_filter('the_content', 'insert_ads_before_post', 5);

// Insert ads after post content in single posts
function insert_ads_after_post($content) {
    if (is_single() && get_option('insert_ads_after_post_enabled')) {
        $ad_content = do_shortcode('[adsense_ad_with_slot_id]');
        $content .= $ad_content;
    }
    return $content;
}
add_filter('the_content', 'insert_ads_after_post');

// Insert ads after paragraphs in single posts
// function insert_ads_after_paragraph($content) {
//     $ads_enabled = get_option('insert_ads_after_paragraph_enabled'); // Get the status of the checkbox
//     if (is_single() && $ads_enabled) { // Check if it's a single post and ads insertion is enabled
//         $paragraphs = explode("</p>", $content);
//         for ($i = 2; $i < count($paragraphs); $i += 3) {
//             $paragraphs[$i] .= '[adsense_ad_with_slot_id]';
//         }
//         $content = implode("</p>", $paragraphs);
//     }
//     return $content;
// }
// add_filter('the_content', 'insert_ads_after_paragraph');

// Insert ads after specific word count in single posts
// Insert ads after specific word count in single posts
// Insert ads after specific word count in single posts
function insert_ads_after_words($content) {
    if (is_single() && get_option('insert_ads_after_paragraph_enabled')) {
        $word_count = get_option('insert_ads_after_word_count', 25); // Default to 250 words if not set
        $word_count = (int)$word_count;
        if ($word_count <= 0) {
            $word_count = 25;
        }

        $words = explode(' ', $content);
        $total_words = count($words);
        $ad_content = do_shortcode('[adsense_ad_with_slot_id]');

        for ($i = $word_count; $i < $total_words; $i += $word_count) {
            array_splice($words, $i, 0, $ad_content);
            $i += count(explode(' ', $ad_content)); // Adjust index for the inserted ad content
        }

        $content = implode(' ', $words);
    }
    return $content;
}
add_filter('the_content', 'insert_ads_after_words');




// Shortcode to insert AdSense ad unit
function rotate_named_adsense_ads_shortcode() {
    ob_start();
    display_adsense_ad_unit();
    return ob_get_clean();
}
add_shortcode('rotate_named_adsense_ads', 'rotate_named_adsense_ads_shortcode');

//Function to hide notification
function pr_disable_admin_notices() {
    global $wp_filter;
        if ( is_user_admin() ) {
            if ( isset( $wp_filter['user_admin_notices'] ) ) {
                            unset( $wp_filter['user_admin_notices'] );
            }
        } elseif ( isset( $wp_filter['admin_notices'] ) ) {
                    unset( $wp_filter['admin_notices'] );
        }
        if ( isset( $wp_filter['all_admin_notices'] ) ) {
                    unset( $wp_filter['all_admin_notices'] );
        }
}
add_action( 'admin_print_scripts', 'pr_disable_admin_notices' );

// Function to insert ads in the footer
function insert_ads_in_footer() {
    if (get_option('insert_ads_in_footer_enabled')) {
        echo do_shortcode('[adsense_ad_with_slot_id]');
    }
}
add_action('wp_footer', 'insert_ads_in_footer');

// Function to clear the transient on page refresh
function clear_ad_unit_transient() {
    delete_transient('selected_adsense_ad_unit');
}
add_action('wp_head', 'clear_ad_unit_transient');


// Insert the AdSense ad shortcode into the header
function insert_ads_in_header() {
    echo do_shortcode('[rotate_named_adsense_ads]');
}
add_action('wp_head', 'insert_ads_in_header');


?>
