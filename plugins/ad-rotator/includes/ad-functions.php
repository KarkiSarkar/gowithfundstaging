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
    
    if ($selected_ad) {
        ?>
         
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
    if ($selected_ad) {
        ob_start();
        ?>
       <div align="center" style="clear: both;">
            <p>Sponsered Link</p>
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-<?php echo $selected_ad['ad_unit']; ?>" crossorigin="anonymous"></script>
        <ins class="adsbygoogle"
            style="display:block; width: 100%;"
            data-ad-client="ca-pub-<?php echo $selected_ad['ad_unit']; ?>"
            data-ad-slot="<?php echo $selected_ad['slot_id']; ?>"
            data-ad-format="auto"
            data-full-width-responsive="true"></ins>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
        </div>
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

// function insert_ads_after_words($content) {
//     if (is_single() && get_option('insert_ads_after_paragraph_enabled')) {
//         $word_count = get_option('insert_ads_after_word_count', 75); // Default to 25 words if not set
//         $word_count = (int)$word_count;
//         if ($word_count <= 0) {
//             $word_count = 75;
//         }

//         // Split content into words using any whitespace characters
//         $words = preg_split('/\s+/', $content);
//         $total_words = count($words);
//         $ad_content = do_shortcode('[adsense_ad_with_slot_id]');

//         $insertion_index = $word_count;
//         $inside_heading = false; // Flag to skip insertion inside heading tags
//         for ($i = 0; $i < $total_words; $i++) {
//             if (preg_match('/<(h[1-6])>/', $words[$i])) {
//                 $inside_heading = true; // Start of heading tag, set the flag
//             } elseif (preg_match('/<\/(h[1-6])>/', $words[$i])) {
//                 $inside_heading = false; // End of heading tag, reset the flag
//             }

//             if (!$inside_heading && $i >= $insertion_index) {
//                 array_splice($words, $i, 0, $ad_content); // Insert ad content
//                 $total_words = count($words); // Update total words count after insertion
//                 $insertion_index += $word_count + 1; // Move insertion index to next word count + 1 to account for newly inserted ad
//                 $i += count(explode(' ', $ad_content)); // Adjust index for the inserted ad content
//             }
//         }

//         $content = implode(' ', $words);
//     }
//     return $content;
// }
// add_filter('the_content', 'insert_ads_after_words');

function insert_ads_after_words($content) {
    if (is_single() && get_option('insert_ads_after_paragraph_enabled')) {
        $word_count = get_option('insert_ads_after_word_count', 300); // Default to 75 words if not set
        $word_count = (int)$word_count;
        if ($word_count <= 0) {
            $word_count = 300;
        }

        // Split content into paragraphs
        $paragraphs = explode('</p>', $content);
        $new_content = '';
        $words_since_last_ad = 0;
        $ad_content = do_shortcode('[adsense_ad_with_slot_id]');
        
        foreach ($paragraphs as $paragraph) {
            // Remove empty paragraphs caused by multiple consecutive newlines
            if (trim($paragraph) === '') {
                continue;
            }

            // Split paragraph into words
            $words = preg_split('/\s+/', $paragraph);
            $word_count_in_paragraph = count($words);
            $words_since_last_ad += $word_count_in_paragraph;

            // Add paragraph to new content
            $new_content .= $paragraph . '</p>';

            // If word count threshold is reached, insert an ad
            if ($words_since_last_ad >= $word_count) {
                $new_content .= $ad_content;
                $words_since_last_ad = 0;
            }
        }

        $content = $new_content;
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

function add_shortcode_before_sidebar() {
    if (is_single() && get_option('insert_ads_before_sidebar_enabled')) {
        echo do_shortcode('[adsense_ad_with_slot_id]');
    }
}
add_action('dynamic_sidebar_before', 'add_shortcode_before_sidebar');

function add_shortcode_after_sidebar() {
   if (is_single() && get_option('insert_ads_after_sidebar_enabled')) {
        echo do_shortcode('[adsense_ad_with_slot_id]');
   }
}
add_action('dynamic_sidebar_after', 'add_shortcode_after_sidebar');

// function insert_content_after_third_post() {
//     if (get_option('insert_ads_in_between_content_enabled')) {
//        if (!is_front_page() && !is_page(array('about', 'contact')) && !is_single() && is_main_query()) {
//             // Increment post counter
//             if (in_the_loop() && is_main_query()) {
//                 global $post_counter;
//                 if (!isset($post_counter)) {
//                     $post_counter = 0;
//                 }
//                 $post_counter++;
        
//                 // Check if it's the 3rd post
//                   // Check if it's the 3rd post
//                 if ($post_counter >= 1 && ($post_counter - 1) % 6 == 0) {
//                     echo do_shortcode('[adsense_ad_with_slot_id]');
//                 }
//             }
//        }
//     }
// }
// add_action('the_post', 'insert_content_after_third_post');
function insert_content_after_third_post($content) {
    if (get_option('insert_ads_in_between_content_enabled')) {
        if (!is_front_page() && !is_page(array('about', 'contact')) && !is_single() && is_main_query()) {
            global $post_counter;

            // Initialize post counter if not already set
            if (!isset($post_counter)) {
                $post_counter = 0;
            }

            // Increment post counter within the loop
            if (in_the_loop() && is_main_query()) {
                $post_counter++;

                // Check if it's every 3rd post
                if ($post_counter % 3 == 0) {
                    $content .= do_shortcode('[adsense_ad_with_slot_id]');
                }
            }
        }
    }
    return $content;
}
add_filter('the_content', 'insert_content_after_third_post');


// // Add shortcode after the navbar
// function add_content_after_top_nav() {
//     echo  do_shortcode('[adsense_ad_with_slot_id]');
// }
// add_action('wp_nav_menu', 'add_content_after_top_nav');



?>
