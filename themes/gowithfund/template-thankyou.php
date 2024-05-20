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
get_footer();
?>