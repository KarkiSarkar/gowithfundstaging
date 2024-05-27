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


function enqueue_facebook_conversion_api_script() {
    // Enqueue jQuery if it's not already loaded
    wp_enqueue_script('jquery');

    // Register a dummy script handle to attach the inline script
    wp_register_script('facebook-conversion-api', false);

    // The JavaScript snippet you want to add
    $facebook_conversion_api_script = "
        FB.api(
            '/484103824186469/events',
            'POST',
            {
                \"data\": \"[{\\\"action_source\\\":\\\"website\\\",\\\"event_id\\\":12345,\\\"event_name\\\":\\\"TestEvent\\\",\\\"event_time\\\":1716798499,\\\"user_data\\\":{\\\"client_ip_address\\\":\\\"254.254.254.254\\\",\\\"client_user_agent\\\":\\\"Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:63.0) Gecko/20100101 Firefox/63.0\\\",\\\"em\\\":\\\"f660ab912ec121d1b1e928a0bb4bc61b15f5ad44d5efdc4e1c92a25e99b8e44a\\\"}}]\", 
                \"test_event_code\": \"TEST93112\"
            },
            function(response) {
                // Insert your code here
                console.log(response);
            }
        );
    ";

    // Add the inline script
    wp_add_inline_script('facebook-conversion-api', $facebook_conversion_api_script);

    // Enqueue the dummy script handle
    wp_enqueue_script('facebook-conversion-api');
}
add_action('wp_enqueue_scripts', 'enqueue_facebook_conversion_api_script');


?>