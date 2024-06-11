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


// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Handle form submission
    if (handle_form_submission()) {
        echo '<p>Thank you for your message!</p>';
    } else {
        echo '<p>There was an error processing your message. Please try again later.</p>';
    }
}

// Start the WordPress loo
    ?>
    <div id="primary" class="content-area">
        <main id="main" class="site-main">
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
                </header><!-- .entry-header -->

                <div class="entry-content">
                    <form id="simple-form" method="post" action="">
                        <p>
                            <label for="name">Name:</label>
                            <input type="text" id="name" name="name" required>
                        </p>
                        <p>
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" required>
                        </p>
                        <p>
                            <label for="message">Message:</label>
                            <textarea id="message" name="message" required></textarea>
                        </p>
                        <p>
                            <input type="submit" name="submit" value="Send">
                        </p>
                    </form>
                </div><!-- .entry-content -->
            </article><!-- #post-<?php the_ID(); ?> -->
        </main><!-- #main -->
    </div><!-- #primary -->
<?php
// End the WordPress loop


// Handle form submission function
function handle_form_submission() {
    if (isset($_POST['submit'])) {
        $name = sanitize_text_field($_POST['name']);
        $email = sanitize_email($_POST['email']);
        $message = sanitize_textarea_field($_POST['message']);

        // Recipient email address
        $recipient_email = 'prabin@nydoz.com'; // Replace with your recipient email

        // Email subject
        $email_subject = 'New Message from Simple Form';

        // Email message
        $email_message = "Name: $name\n";
        $email_message .= "Email: $email\n";
        $email_message .= "Message: $message\n";

        // Send email
        return wp_mail($recipient_email, $email_subject, $email_message);
    }
    return false;
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
