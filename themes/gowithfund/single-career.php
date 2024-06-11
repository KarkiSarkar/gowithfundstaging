<?php

    get_header(); 

    $page_id = krowd_id();
    $default_sidebar_config = krowd_get_option('single_post_sidebar', 'right-sidebar'); 
    $default_left_sidebar = krowd_get_option('single_post_left_sidebar', 'default_sidebar');
    $default_right_sidebar = krowd_get_option('single_post_right_sidebar', 'default_sidebar');

    $sidebar_layout_config = get_post_meta($page_id, 'krowd_sidebar_config', true);
    $left_sidebar = get_post_meta($page_id, 'krowd_left_sidebar', true);
    $right_sidebar = get_post_meta($page_id, 'krowd_right_sidebar', true);

    if ($sidebar_layout_config == "") {
        $sidebar_layout_config = $default_sidebar_config;
    }
    if ($left_sidebar == "") {
        $left_sidebar = $default_left_sidebar;
    }
    if ($right_sidebar == "") {
        $right_sidebar = $default_right_sidebar;
    }

   $left_sidebar_config  = array('active' => false);
   $right_sidebar_config = array('active' => false);
   $main_content_config  = array('class' => 'col-lg-12 col-xs-12');

    $sidebar_config = krowd_sidebar_global($sidebar_layout_config, $left_sidebar, $right_sidebar);
   
    extract($sidebar_config);

 ?>
 <style>
    .page-title{
        padding-top: 3rem;
    }
    input[type="text"], input[type="tel"], input[type="password"], input[type="email"], textarea, select {
    background-color: #fff;
    -webkit-box-shadow: 0 0 2px 2px rgba(0, 0, 0, 0.02) inset;
    box-shadow: 0 0 2px 2px rgba(0, 0, 0, 0.02) inset;
    border: 1px solid #E9E9EE;
    padding: 5px 10px;
    max-width: 100%;
    border-radius: 0;
    width: 100%;
}
</style>
<section id="wp-main-content" class="clearfix main-page">
    <?php do_action( 'krowd_before_page_content' ); ?>
   <div class="container">  
    <div class="main-page-content row">
         <div class="content-page <?php echo esc_attr($main_content_config['class']); ?>">      
            <div id="wp-content" class="wp-content clearfix">
            <div class="entry-header">
        <?php if ( has_post_thumbnail() ) : ?>
            <a href="<?php the_permalink(); ?>">
                <?php echo get_the_post_thumbnail( $post->ID, 'medium' ); ?>
            </a>
        <?php endif; ?>

       
        <div>
            <strong>Job Title:</strong> <?php echo esc_html( the_title()); ?>
        </div>
        <div>
            <strong>Company Name:</strong> <?php echo esc_html( get_post_meta( get_the_ID(), '_career_company', true ) ); ?>
        </div>
        <div>
            <strong>Location:</strong> <?php echo esc_html( get_post_meta( get_the_ID(), '_career_location', true ) ); ?>
        </div>
        
    </div><!-- .entry-header -->

    <div class="entry-content">
        <?php the_content(); ?>
    </div><!-- .entry-content -->
    <div style="border: 1px solid #00A9A5; padding: 20px; background: #00A9A5; color: white; margin: 20px 0px;">
        <?php //echo do_shortcode('[simple_form]'); ?>








<!-- Custom Start -->

    <form id="simple-form-ui" method="post" action="" enctype="multipart/form-data">
    <input type="hidden" name="sfs_page_name" value="<?php echo get_the_title();?>">
        <p>
            <label for="sfs_name">Name:</label>
            <input type="text" id="sfs_name" name="sfs_name" >
        </p>
        <p>
            <label for="sfs_email">Email:</label>
            <input type="email" id="sfs_email" name="sfs_email" >
        </p>
        <p>
            <label for="sfs_file">File:</label>
            <input type="file" id="sfs_file" name="sfs_file">
        </p>
        <p>
            <input type="submit" name="sfs_submit" value="Send">
        </p>
        <div id="error-container"></div>
    </form>
    <script>
document.addEventListener('DOMContentLoaded', function() {
    // Check if there are errors stored in sessionStorage
    var storedErrors = sessionStorage.getItem('formErrors');
    if (storedErrors) {
        displayErrors(JSON.parse(storedErrors));
        // Clear the stored errors after displaying them
        sessionStorage.removeItem('formErrors');
        // Scroll to the error container
        document.getElementById('error-container').scrollIntoView();
    }
});

document.getElementById('simple-form-ui').addEventListener('submit', function(event) {
    var name = document.getElementById('sfs_name').value;
    var email = document.getElementById('sfs_email').value;
    var phoneNumber = document.getElementById('sfs_phonenumber').value;
    var country = document.getElementById('country').value;
    var message = document.getElementById('sfs_message').value;

    var errors = [];

    if (!name) {
        errors.push("Please enter your name.");
        document.getElementById('sfs_name').classList.add('error');
    } else {
        document.getElementById('sfs_name').classList.remove('error');
    }

    if (!email) {
        errors.push("Please enter your email address.");
        document.getElementById('sfs_email').classList.add('error');
    } else if (!validateEmail(email)) {
        errors.push("Please enter a valid email address.");
        document.getElementById('sfs_email').classList.add('error');
    } else {
        document.getElementById('sfs_email').classList.remove('error');
    }

   

    if (errors.length > 0) {
        event.preventDefault(); // Prevent form submission
        // Store errors in sessionStorage
        sessionStorage.setItem('formErrors', JSON.stringify(errors));
        displayErrors(errors);
        // Scroll to the error container
        document.getElementById('error-container').scrollIntoView();
    }
});

function validateEmail(email) {
    var re = /\S+@\S+\.\S+/;
    return re.test(email);
}

function displayErrors(errors) {
    var errorContainer = document.getElementById('error-container');
    errorContainer.innerHTML = ''; // Clear previous errors

    var errorList = document.createElement('ul');
    errors.forEach(function(error) {
        var listItem = document.createElement('li');
        listItem.textContent = error;
        errorList.appendChild(listItem);
    });

    errorContainer.appendChild(errorList);
}

  window.fbAsyncInit = function() {
    FB.init({
      appId            : '484103824186469',
      xfbml            : true,
      version          : 'v20.0'
    });
  };
  
</script>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js"></script>
    <script>
         document.getElementById('simple-form-ui').addEventListener('submit', function(event) {
            var formData = new FormData(this);
            var data = {};
            formData.forEach((value, key) => {
            data[key] = value;
            });

            // Perform the lead tracking with form data
            fbq('track', 'Lead', data);
            // Submit the form after tracking
            this.submit();
        });
    </script>
    <?php
   

// Handle form submission
function sfs_handle_form_submission() {
    if (isset($_POST['sfs_submit'])) {
        $name = sanitize_text_field($_POST['sfs_name']);
        $email = sanitize_email($_POST['sfs_email']);
        $page_name = isset($_POST['sfs_page_name'])? sanitize_text_field($_POST['sfs_page_name']) : '';
        $file = isset($_FILES['sfs_file'])? $_FILES['sfs_file'] : null;
        
        // Personal email address for receiving form submissions
        $recipient_email = $email; // Replace with your personal email
        

        global $post;
        $post_name = get_the_title($post->ID);
        $post_type = get_post_type_object(get_post_type($post->ID));
        $post_type_name = $post_type->labels->singular_name;
        // Construct email subject with page name (if available)
        $email_subject = 'New Contact Form Submission';
        if (!empty($page_name)) {
            $email_subject.= ' from '. $page_name .'(' . $post_type_name . ')';
        }
        
        
        // Construct email message
        $email_message = "<html><body>";
        $email_message.= "<h2>User Request for $page_name ( $post_type_name )'</h2>";
        $email_message.= "<p>Name: $name</p>";
        $email_message.= "<p>Email: $email\n</p>";
       
        // Handle file upload
        if ($file) {
            $upload_dir = wp_upload_dir();
            $file_name = basename($file['name']);
            $file_path = $upload_dir['path']. '/'. $file_name;
            if (move_uploaded_file($file['tmp_name'], $file_path)) {
                $email_message.= "\n\nFile: $file_name\n";
                $email_message.= "File URL: ". $upload_dir['url']. '/'. $file_name;
            }
        }
        $attachments = array();
        if ($file) {
            $attachments[] = $file_path;
        }
         $email_message.= "</body></html>";
       
        // Example: Send an email
        wp_mail($recipient_email, $email_subject, $email_message, array('Content-Type: text/html; charset=UTF-8', 'From: '. $name. ' <'. $email. '>'), $attachments);
        
        // Display a thank you message
        add_action('the_content', function($content) {
            return '<p>Thank you for your message!</p>'. $content;
        });
    }
}
add_action('wp', 'sfs_handle_form_submission');
function add_facebook_sdk() {
    echo "
    <script>
      window.fbAsyncInit = function() {
        FB.init({
          appId      : '484103824186469', // Replace with your app ID
          xfbml      : true,
          version    : 'v19.0'
        });
      };

      (function(d, s, id){
         var js, fjs = d.getElementsByTagName(s)[0];
         if (d.getElementById(id)) {return;}
         js = d.createElement(s); js.id = id;
         js.src = \"https://connect.facebook.net/en_US/sdk.js\";
         fjs.parentNode.insertBefore(js, fjs);
       }(document, 'script', 'facebook-jssdk'));
    </script>";
}
add_action('wp_head', 'add_facebook_sdk');

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

        // Send data to Facebook Conversion API
        send_event_to_facebook($name, $email, $page_name, $message);
        $thank_you_page_url = home_url('/become-a-partner/thank-you'); // Replace with your thank you page URL
        wp_redirect($thank_you_page_url);
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

<!-- Custom end -->

















    </div>
    <div class="entry-footer">
        
        
    </div><!-- .entry-footer -->
            </div>    
         </div>      

         <!-- Left sidebar -->
         <?php if($left_sidebar_config['active']): ?>
         <div class="sidebar wp-sidebar sidebar-left <?php echo esc_attr($left_sidebar_config['class']); ?>">
            <?php do_action( 'krowd_before_sidebar' ); ?>
            <div class="sidebar-inner">
               <?php dynamic_sidebar($left_sidebar_config['name'] ); ?>
            </div>
            <?php do_action( 'krowd_after_sidebar' ); ?>
         </div>
         <?php endif ?>

         <!-- Right Sidebar -->
         <?php if($right_sidebar_config['active']): ?>
         <div class="sidebar wp-sidebar sidebar-right <?php echo esc_attr($right_sidebar_config['class']); ?>">
            <?php do_action( 'krowd_before_sidebar' ); ?>
               <div class="sidebar-inner">
                  <?php dynamic_sidebar($right_sidebar_config['name'] ); ?>
               </div>
            <?php do_action( 'krowd_after_sidebar' ); ?>
         </div>
         <?php endif ?>
         
      </div>   
    </div>
    <?php do_action( 'krowd_after_page_content' ); ?>
    
    
</section>

<?php get_footer(); ?>
