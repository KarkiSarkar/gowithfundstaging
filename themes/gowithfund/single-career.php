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

<?php



// Handle form submission
function cfs_handle_career_application() {
    if (isset($_POST['cfs_submit'])) {
        $name = sanitize_text_field($_POST['cfs_name']);
        $email = sanitize_email($_POST['cfs_email']);
        $file = isset($_FILES['cfs_file']) ? $_FILES['cfs_file'] : null;

        // Email address for receiving career applications
        $recipient_email = 'careers@example.com'; // Replace with your recipient email

        // Construct email subject
        $email_subject = 'New Career Application';

        // Construct email message
        $email_message = "<html><body>";
        $email_message.= "<h2>Career Application</h2>";
        $email_message.= "<p>Name: $name</p>";
        $email_message.= "<p>Email: $email</p>";

        // Handle file upload
        $attachments = array();
        if ($file) {
            $upload_dir = wp_upload_dir();
            $file_name = basename($file['name']);
            $file_path = $upload_dir['path'] . '/' . $file_name;
            if (move_uploaded_file($file['tmp_name'], $file_path)) {
                $email_message .= "\n\nFile: $file_name\n";
                $email_message .= "File URL: " . $upload_dir['url'] . '/' . $file_name;
                $attachments[] = $file_path;
            }
        }
        $email_message.= "</body></html>";

        // Send email
        wp_mail($recipient_email, $email_subject, $email_message, array('Content-Type: text/html; charset=UTF-8'), $attachments);

        // Redirect to a thank you page
        $thank_you_page_url = home_url('/career/thank-you'); // Replace with your thank you page URL
        wp_redirect($thank_you_page_url);
        exit();
    }
}
add_action('wp', 'cfs_handle_career_application');


?>
<form id="career-application-form" method="post" action="" enctype="multipart/form-data">
    <input type="hidden" name="cfs_page_name" value="<?php echo get_the_title(); ?>">
    <p>
        <label for="cfs_name">Name:</label>
        <input type="text" id="cfs_name" name="cfs_name" required>
    </p>
    <p>
        <label for="cfs_email">Email:</label>
        <input type="email" id="cfs_email" name="cfs_email" required>
    </p>
    <p>
        <label for="cfs_file">Resume (PDF only):</label>
        <input type="file" id="cfs_file" name="cfs_file" accept=".pdf" required>
    </p>
    <p>
        <input type="submit" name="cfs_submit" value="Submit">
    </p>
</form>


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
