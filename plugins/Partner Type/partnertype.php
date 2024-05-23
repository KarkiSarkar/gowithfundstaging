<?php
/*
Plugin Name: PartnerType Form
Description: Plugin to generate a custom contact form with file upload and send emails upon submission.
Version: 1.0
Author: Nydoz Team
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Shortcode function to display the form
function sfs_display_form() {
    ob_start();
   ?>
    <form method="post" action="" enctype="multipart/form-data">
    <input type="hidden" name="sfs_page_name" value="<?php echo get_the_title();?>">
        <p>
            <label for="sfs_name">Name:</label>
            <input type="text" id="sfs_name" name="sfs_name" required>
        </p>
        <p>
            <label for="sfs_email">Email:</label>
            <input type="email" id="sfs_email" name="sfs_email" required>
        </p>
        <p>
            <label for="sfs_message">Message:</label>
            <textarea id="sfs_message" name="sfs_message" required></textarea>
        </p>
        <p>
            <label for="sfs_file">File:</label>
            <input type="file" id="sfs_file" name="sfs_file">
        </p>
        <p>
            <input type="submit" name="sfs_submit" value="Send">
        </p>
    </form>
    <?php
    return ob_get_clean();
}

// Shortcode registration
function sfs_register_shortcodes() {
    add_shortcode('simple_form', 'sfs_display_form');
}
add_action('init', 'sfs_register_shortcodes');

// Handle form submission
function sfs_handle_form_submission() {
    if (isset($_POST['sfs_submit'])) {
        $name = sanitize_text_field($_POST['sfs_name']);
        $email = sanitize_email($_POST['sfs_email']);
        $page_name = isset($_POST['sfs_page_name'])? sanitize_text_field($_POST['sfs_page_name']) : '';
        $message = sanitize_textarea_field($_POST['sfs_message']);
        $file = isset($_FILES['sfs_file'])? $_FILES['sfs_file'] : null;
        
        // Personal email address for receiving form submissions
        $recipient_email = 'prabin@nydoz.com'; // Replace with your personal email
        
        // Construct email subject with page name (if available)
        $email_subject = 'New Contact Form Submission';
        if (!empty($page_name)) {
            $email_subject.= ' from '. $page_name;
        }
        
        // Construct email message
        $email_message = "Name: $name\n";
        $email_message.= "Email: $email\n";
        if (!empty($page_name)) {
            $email_message.= "Page Name: $page_name\n\n";
        }
        $email_message.= "Message:\n$message";
        
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
        
        // Example: Send an email
        wp_mail($recipient_email, $email_subject, $email_message, array('Content-Type: text/html; charset=UTF-8', 'From: '. $name. ' <'. $email. '>'));
        
        // Display a thank you message
        add_action('the_content', function($content) {
            return '<p>Thank you for your message!</p>'. $content;
        });
    }
}
add_action('wp', 'sfs_handle_form_submission');

?>