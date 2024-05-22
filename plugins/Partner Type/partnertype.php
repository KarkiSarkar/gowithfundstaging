<?php
/*
Plugin Name: PartnerType Form
Description: Plugin to generate a custom contact form and send emails upon submission.
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
    <form method="post" action="">
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
        $message = sanitize_textarea_field($_POST['sfs_message']);
        
        // Process the form data here (e.g., send an email or save to the database)
        
        // Example: Send an email
        wp_mail(get_option('admin_email'), 'New Contact Form Submission', $message, array('Content-Type: text/html; charset=UTF-8', 'From: ' . $name . ' <' . $email . '>'));
        
        // Display a thank you message
        add_action('the_content', function($content) {
            return '<p>Thank you for your message!</p>' . $content;
        });
    }
}
add_action('wp', 'sfs_handle_form_submission');

?>