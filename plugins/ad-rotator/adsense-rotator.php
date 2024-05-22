<?php
/*
Plugin Name: AdSense Rotator
Description: Rotates Google AdSense ad codes and generates shortcode.
Version: 3.0
Author: Nydoz Team
*/

// Function to rotate AdSense ad units with names
function rotate_named_adsense_ads() {
    // Start session
    // if (!session_id()) {
    //     session_start();
    // }

    // Check if the session variable is set
    if (!isset($_SESSION['selected_ad_unit'])) {
        // Randomly select an ad unit
        $_SESSION['selected_ad_unit'] = array_rand(get_rotated_ad_units());
    }

    // Get the selected ad unit
    $selected_ad = get_rotated_ad_units()[$_SESSION['selected_ad_unit']];
    

    // Output the ad unit
    ?>
     <?php if (!is_user_logged_in()) {?> 
        <div style="display: none;">
    <p style="text-align: center;"><?php echo $selected_ad['name']; ?></p>
    
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=<?php echo $selected_ad['client_id']; ?>&amp;cachebuster=<?php echo time(); ?>"
     crossorigin="anonymous"></script>
    <ins class="adsbygoogle"
         style="display:block"
         data-ad-client="<?php echo $selected_ad['client_id']; ?>"
         data-ad-slot="<?php echo $selected_ad['slot_id']; ?>"
         data-ad-format="auto"
         data-full-width-responsive="true"></ins>
    <script>
         (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
    </div>
    <?php
}
}
 header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
// function insert_ads_after_paragraph($content) {
//     // Split content into paragraphs
//     $paragraphs = explode("</p>", $content);

//     // Insert shortcode after each paragraph
//     foreach ($paragraphs as $index => $paragraph) {
//         // Append shortcode after each paragraph
//         $paragraphs[$index] .= '[rotate_named_adsense_ads]';
//     }

//     // Join paragraphs back together
//     $content = implode("</p>", $paragraphs);

//     return $content;
// }
// add_filter('the_content', 'insert_ads_after_paragraph');
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

// Function to get rotated AdSense ad units
function get_rotated_ad_units() {
    // Array of named AdSense ad units
    $ad_units = array(
        'ad_unit_1' => array(
            'client_id' => 'ca-pub-xxxxxxxxxx',
            'slot_id' => 'xxxxxxxxx',
            'name' => 'Sponsered1',
        ),
        'ad_unit_2' => array(
            'client_id' => 'ca-pub-yyyyyyyyy',
            'slot_id' => 'yyyyyyyyy',
            'name' => 'Sponsered2',
            
        ),
        'ad_unit_3' => array(
            'client_id' => 'ca-pub-uuuuuuuuuuu',
            'slot_id' => 'uuuuuuuuu',
            'name' => 'Sponsered3',),
            
        
        
    );

    return $ad_units;
}
