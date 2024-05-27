<?php
// Your code to enqueue parent theme styles
function enqueue_parent_styles() {
   wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
}

add_action( 'wp_enqueue_scripts', 'enqueue_parent_styles' );
add_action( 'wp_enqueue_scripts', 'grand_sunrise_enqueue_styles' );

function grand_sunrise_enqueue_styles() {
    $style_version = filemtime( get_stylesheet_directory() . '/style.css' );
    wp_enqueue_style( 
        'grand-sunrise-style', 
        get_stylesheet_uri(),
        array(),
        $style_version
    );
}
add_action( 'wp_enqueue_scripts', 'grand_sunrise_enqueue_styles' );


// Add page title as body class
function add_page_title_as_body_class($classes) {
    // Get the page title
    $page_title = get_the_title();
    
    // Sanitize the page title to make it suitable as a class name
    $sanitized_page_title = sanitize_title($page_title);
    
    // Add the sanitized page title as a class
    $classes[] = $sanitized_page_title;

    return $classes;
}
add_filter('body_class', 'add_page_title_as_body_class');
// Assign "subscriber" role to new users
function assign_subscriber_role_on_registration($user_id) {
    $user = new WP_User($user_id);
    $user->set_role('campaign_creator');
}
add_action('user_register', 'assign_subscriber_role_on_registration', 10, 1);
// function restrict_campaign_creators_from_admin_panel() {
//     if (current_user_can('campaign_creator')) {
//         wp_redirect(home_url());
//         exit;
//     }
// }
// add_action('admin_init', 'restrict_campaign_creators_from_admin_panel');

// function modify_curl_headers( $handle ) {
//     curl_setopt( $handle, CURLOPT_HTTPHEADER, array(
//         'Access-Control-Allow-Origin: https://js.stripe.com'
//     ) );
//     return $handle;
// }
// add_filter( 'http_api_curl', 'modify_curl_headers' );


// Add CSS to hide admin bar for users with 'campaign_creator' role
function hide_admin_bar_css() {
    if (current_user_can('campaign_creator')) {
        echo '<style>
            #wpadminbar {
                display:none;
            }
            html {
                margin-top: 0!important;
            }
        </style>';
    }
}
add_action('admin_head', 'hide_admin_bar_css');
add_action('wp_head', 'hide_admin_bar_css');


// Register Success Story Post Type
function create_success_story_post_type() {
    $labels = array(
        'name'               => _x( 'Success Stories', 'post type general name', 'textdomain' ),
        'singular_name'      => _x( 'Success Story', 'post type singular name', 'textdomain' ),
        'menu_name'          => _x( 'Success Stories', 'admin menu', 'textdomain' ),
        'name_admin_bar'     => _x( 'Success Story', 'add new on admin bar', 'textdomain' ),
        'add_new'            => _x( 'Add New', 'success story', 'textdomain' ),
        'add_new_item'       => __( 'Add New Success Story', 'textdomain' ),
        'new_item'           => __( 'New Success Story', 'textdomain' ),
        'edit_item'          => __( 'Edit Success Story', 'textdomain' ),
        'view_item'          => __( 'View Success Story', 'textdomain' ),
        'all_items'          => __( 'All Success Stories', 'textdomain' ),
        'search_items'       => __( 'Search Success Stories', 'textdomain' ),
        'parent_item_colon'  => __( 'Parent Success Stories:', 'textdomain' ),
        'not_found'          => __( 'No success stories found.', 'textdomain' ),
        'not_found_in_trash' => __( 'No success stories found in Trash.', 'textdomain' )
    );

    $args = array(
        'labels'             => $labels,
        'description'        => __( 'Description.', 'textdomain' ),
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'success-story' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ),
        'taxonomies'         => array( 'success_story_category' ) // Add support for categories
    );

    register_post_type( 'success_story', $args );

    // Register Success Story Category Taxonomy
    register_taxonomy(
        'success_story_category',
        'success_story',
        array(
            'label' => __( 'Categories', 'textdomain' ),
            'rewrite' => array( 'slug' => 'success-story-category' ),
            'hierarchical' => true,
        )
    );
}
add_action( 'init', 'create_success_story_post_type' );

// Function to fetch Facebook object
function fetch_facebook_object($object_id, $access_token) {
    $url = "https://graph.facebook.com/{$object_id}?access_token={$access_token}";

    $response = wp_remote_get($url);

    if (is_wp_error($response)) {
        error_log('Request failed: ' . $response->get_error_message());
        return 'Request failed: ' . $response->get_error_message();
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    if (isset($data['error'])) {
        error_log('Error: ' . print_r($data['error'], true));
        return 'Error: ' . $data['error']['message'] . ' (Code: ' . $data['error']['code'] . ')';
    }

    return $data;
}

// Shortcode to display Facebook object data
function display_facebook_object($atts) {
    $atts = shortcode_atts(array(
        'id' => '484103824186469', // Facebook object ID
        'token' => 'EAACoB29AeEoBOxwtPQsgIOmRnNLW34UIadZBvo0isaC48s7jb5ZBP2yWu4secBiwcirJUT286yer8qRlZBaf9lEJPkneGSYnFpWRXpdZAGZAnCNOUYZC39dgeVC8riIChNEUZCYTgVy4tRQXpABY7EqU7APJVZBk5kfyilUalbgP8i5wVp7LhjTpeCQa4MMjYNluZA9iWbDwtAfZBz8ZBXxnM1diO5NY2NBGdq7zWpP1Jo14FQZCRV8hFNwNo1DbpsskbN3kQvQZD', // Access token
    ), $atts, 'facebook_object');

    if (empty($atts['id']) || empty($atts['token'])) {
        return 'Object ID and access token are required.';
    }

    $data = fetch_facebook_object($atts['id'], $atts['token']);

    if (is_string($data)) {
        return $data;
    }

    // Customize this part to display the data as needed
    return '<pre>' . print_r($data, true) . '</pre>';
}

// Register the shortcode
add_shortcode('facebook_object', 'display_facebook_object');

use FacebookAds\Api;
use FacebookAds\Object\ServerSide\Event;
use FacebookAds\Object\ServerSide\EventRequest;
use FacebookAds\Object\ServerSide\UserData;
use FacebookAds\Object\ServerSide\CustomData;

// Handle form submission
function sfs_handle_form_submissions() {
    if (isset($_POST['sfs_submit'])) {
        // Check if 'sfs_page_name' key is set in $_POST array
        $page_name = isset($_POST['sfs_page_name']) ? sanitize_text_field($_POST['sfs_page_name']) : '';

        // Sanitize other form inputs
        $name = isset($_POST['sfs_name']) ? sanitize_text_field($_POST['sfs_name']) : '';
        $email = isset($_POST['sfs_email']) ? sanitize_email($_POST['sfs_email']) : '';
        $message = isset($_POST['sfs_message']) ? sanitize_textarea_field($_POST['sfs_message']) : '';

        // Personal email address for receiving form submissions
        $recipient_email = 'prabin@nydoz.com'; // Replace with your personal email

       

        // Display a thank you message
        add_action('the_content', function($content) {
            return '<p>Thank you for your message!</p>' . $content;
        });

        // Send data to Facebook Conversion API
        send_event_to_facebook($name, $email, $page_name, $message);
    }
}
add_action('wp', 'sfs_handle_form_submissions');

function send_event_to_facebook($name, $email, $page_name, $message) {
    // Initialize the Facebook SDK
    $access_token = 'EAACoB29AeEoBOxwtPQsgIOmRnNLW34UIadZBvo0isaC48s7jb5ZBP2yWu4secBiwcirJUT286yer8qRlZBaf9lEJPkneGSYnFpWRXpdZAGZAnCNOUYZC39dgeVC8riIChNEUZCYTgVy4tRQXpABY7EqU7APJVZBk5kfyilUalbgP8i5wVp7LhjTpeCQa4MMjYNluZA9iWbDwtAfZBz8ZBXxnM1diO5NY2NBGdq7zWpP1Jo14FQZCRV8hFNwNo1DbpsskbN3kQvQZD'; // Replace with your actual access token
    $pixel_id = '484103824186469'; // Replace with your actual Pixel ID

    Api::init(null, null, $access_token);

    // Create UserData object
    $user_data = (new UserData())
        ->setEmails([hash('sha256', $email)]);

    // Create CustomData object
    $custom_data = (new CustomData())
        ->setContentName($page_name)
        ->setContentCategory('Form Submission')
        ->setContentIds([$message]);

    // Create Event object
    $event = (new Event())
        ->setEventName('Lead')
        ->setEventTime(time())
        ->setUserData($user_data)
        ->setCustomData($custom_data)
        ->setActionSource('website');

    // Create EventRequest object
    $request = (new EventRequest($pixel_id))
        ->setEvents([$event]);

    // Execute the request
    try {
        $response = $request->execute();
        // Log the response or handle it as needed
    } catch (Exception $e) {
        // Handle exceptions
        error_log('Facebook Conversion API error: ' . $e->getMessage());
    }
}

?>