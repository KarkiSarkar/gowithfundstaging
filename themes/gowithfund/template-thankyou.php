<?php
/*
Template Name: Thank You Page
*/
get_header();
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <section class="thank-you">
            <header class="page-header">
                <h1 class="page-title"><?php esc_html_e('Thank You', 'your-text-domain'); ?></h1>
            </header>
            <div class="page-content">
                <p><?php esc_html_e('Thank you for your submission. We will get back to you soon.', 'your-text-domain'); ?></p>
            </div>
        </section>
    </main>
</div>

<?php
function register_partnership_requests_page() {
    add_menu_page(
        'Partnership Requests',
        'Partnership Requests',
        'manage_options',
        'partnership-requests',
        'display_partnership_requests_page',
        'dashicons-list-view',
        6
    );
}

add_action('admin_menu', 'register_partnership_requests_page');


function display_partnership_requests_page() {
    // Query all partnership request posts
    $args = array(
        'post_type' => 'partnership_request',
        'post_status' => 'publish',
        'posts_per_page' => -1,
    );

    $query = new WP_Query($args);
    ?>
    <div class="wrap">
        <h1 class="wp-heading-inline">Partnership Requests</h1>
        <table class="widefat fixed" cellspacing="0">
            <thead>
                <tr>
                    <th id="columnname" class="manage-column column-columnname" scope="col">Name</th>
                    <th id="columnname" class="manage-column column-columnname" scope="col">Email</th>
                    <th id="columnname" class="manage-column column-columnname" scope="col">Country</th>
                    <th id="columnname" class="manage-column column-columnname" scope="col">Phone Number</th>
                    <th id="columnname" class="manage-column column-columnname" scope="col">Investment Type</th>
                    <th id="columnname" class="manage-column column-columnname" scope="col">Interests</th>
                    <th id="columnname" class="manage-column column-columnname" scope="col">Message</th>
                    <th id="columnname" class="manage-column column-columnname" scope="col">Other Profession Type</th>
                    <th id="columnname" class="manage-column column-columnname" scope="col">Attachments</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($query->have_posts()) {
                    while ($query->have_posts()) {
                        $query->the_post();
                        $email = get_post_meta(get_the_ID(), 'email', true);
                        $country = get_post_meta(get_the_ID(), 'country', true);
                        $phone_number = get_post_meta(get_the_ID(), 'phone_number', true);
                        $investment_type = get_post_meta(get_the_ID(), 'investment_type', true);
                        $checkboxes = get_post_meta(get_the_ID(), 'checkboxes', true);
                        $other_text = get_post_meta(get_the_ID(), 'other_text', true);
                        $attachments = get_post_meta(get_the_ID(), 'attachments', true);
                        ?>
                        <tr>
                            <td><?php the_title(); ?></td>
                            <td><?php echo esc_html($email); ?></td>
                            <td><?php echo esc_html($country); ?></td>
                            <td><?php echo esc_html($phone_number); ?></td>
                            <td><?php echo esc_html($investment_type); ?></td>
                            <td><?php echo esc_html($checkboxes); ?></td>
                            <td><?php the_content(); ?></td>
                            <td><?php echo esc_html($other_text); ?></td>
                            <td>
                                <?php
                                if (!empty($attachments)) {
                                    foreach ((array)$attachments as $attachment) {
                                        echo '<a href="' . esc_url(wp_get_attachment_url($attachment)) . '" target="_blank">' . basename($attachment) . '</a><br>';
                                    }
                                }
                                ?>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="9">No partnership requests found.</td>
                    </tr>
                    <?php
                }
                wp_reset_postdata();
                ?>
            </tbody>
        </table>
    </div>
    <?php
}


function process_custom_contact_form() {
    if (isset($_POST['submit'])) {
        $name = sanitize_text_field($_POST['name']);
        $email = sanitize_email($_POST['email']);
        $country = sanitize_text_field($_POST['country']);
        $phoneNumber = sanitize_text_field($_POST['number']);
        $message = sanitize_text_field($_POST['message']);
        $investmentType = isset($_POST['investmentType']) ? sanitize_text_field($_POST['investmentType']) : '';
        $attachments = array(); // Initialize attachments array
            if(isset($_FILES['fileUpload'])) {
                $file_name = $_FILES['fileUpload']['name'];
                $file_tmp = $_FILES['fileUpload']['tmp_name'];
                // Move uploaded file to desired directory
                move_uploaded_file($file_tmp,"/path/to/directory/" . $file_name);
                // Include file information in the email or process it as needed
                $attachments[] = $file_name; // Add file path to attachments array
            }
        // Additional fields for checkboxes
        $checkboxes = "";
        if(isset($_POST['legal'])) $checkboxes .= "Legal, ";
        if(isset($_POST['accountant'])) $checkboxes .= "Accountant, ";
        if(isset($_POST['content'])) $checkboxes .= "Content, ";
        if(isset($_POST['marketing'])) $checkboxes .= "Marketing, ";
        if(isset($_POST['equity'])) $checkboxes .= "Equity, ";
        if(isset($_POST['debt'])) $checkboxes .= "Debt, ";
         if(isset($_POST['legal_representative'])) $checkboxes .= "Legal Representative, ";
        // Remove trailing comma and space
        $checkboxes = rtrim($checkboxes, ", ");

        // Additional field for 'Other' text
        $otherText = "";
        if(isset($_POST['other'])) {
            $otherText = sanitize_text_field($_POST['otherText']);
        }

        $post_data = array(
            'post_title'    => wp_strip_all_tags($name),
            'post_content'  => $message,
            'post_status'   => 'publish',
            'post_type'     => 'partnership_request',
        );
        $post_id = wp_insert_post($post_data);
    
        if ($post_id) {
            update_post_meta($post_id, 'email', $email);
            update_post_meta($post_id, 'country', $country);
            update_post_meta($post_id, 'phone_number', $phoneNumber);
            update_post_meta($post_id, 'investment_type', $investmentType);
            update_post_meta($post_id, 'checkboxes', $checkboxes);
            if (!empty($otherText)) {
                update_post_meta($post_id, 'other_text', $otherText);
            }
            if (!empty($attachments)) {
                update_post_meta($post_id, 'attachments', $attachments);
            }
        }

        // Send email to admin
        $admin_email = $email;
        $admin_subject = 'New Partnership Request Submission';
        $admin_message = "<html><body>";
        $admin_message .= "<h2>User Information</h2>";
        $admin_message .= "<p><strong>Name:</strong> $name</p>";
        $admin_message .= "<p><strong>Email:</strong> $email</p>";
        $admin_message .= "<p><strong>Country:</strong> $country</p>";
        $admin_message .= "<p><strong>Phone Number:</strong> $phoneNumber</p>";
        $admin_message .= "<p><strong>Investment Type:</strong> $investmentType</p>"; // Include selected value
        $admin_message .= "<p><strong>Message:</strong><br>$message</p>";
        $admin_message .= "<p><strong>$investmentType:</strong> $checkboxes</p>";
        if(!empty($otherText)) {
            $admin_message .= "<p><strong>Other Profession Type:</strong> $otherText</p>";
        }
        $admin_message .= "</body></html>";

        
        $admin_headers = array(
            'From: GoWithFund <info@gowithfund.com>',
            'Content-Type: text/html; charset=UTF-8'
        );
         wp_mail($admin_email, $admin_subject, $admin_message, $admin_headers, $attachments);

        // Send email to client
        $client_headers = array(
            'From: GoWithFund <info@gowithfund.com>',
            'Content-Type: text/html; charset=UTF-8'
        );
        $client_subject = 'Thank you for contacting us';
         $client_message = "<div style='text-align: center; background-color: #00A9A5;'><img width='200' src='https://gowithfund.com/wp-content/uploads/2015/12/Final-Logo-white.png'/></div></br><div><h2>Dear $name,</h2></div><p>Thank you for expressing your interest in becoming a partner with GoWithFund. We appreciate your support and enthusiasm for our crowdfunding platform. Our team will review your submission and get back to you soon with further details.</p><div><p>Best regards,</p><p>The GoWithFund Team</p><p>943, 447 Broadway, 2nd Floor</p><p>New York, US</p></div><div><img width='150' src='https://gowithfund.com/wp-content/uploads/2024/05/Gowithfund-Final-Logo-Transparancy-BG.png'/></div>";
        wp_mail($email, $client_subject, $client_message, $client_headers);

        if (!is_admin() && !wp_doing_ajax() && isset($_POST['custom_contact_form_submit'])) {
            wp_redirect(home_url('/become-a-partner'));
            exit();
        }

    }
}
add_action('init', 'process_custom_contact_form');


get_footer();
?>