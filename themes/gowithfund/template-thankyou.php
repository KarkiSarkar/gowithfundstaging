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
                        <h1 class="page-title" style="text-align: center;"><?php esc_html_e('Thank You', 'krowd'); ?></h1>
                    </header>
                    <div class="page-content">
                        <p style="text-align: center;"><?php esc_html_e('Thank you for your request on becoming a partner. We will get back to you soon.', 'krowd'); ?></p>
                    </div>

                </section>
            </main>
        </div>

        <?php
        get_footer();
        ?>
        
<script>
// JavaScript to redirect to home page when the Thank You page is refreshed
window.onload = function() {
    if(performance.navigation.type == 1) {
        window.location.href = '<?php echo esc_url( home_url( '/' ) ); ?>';
    }
}
</script>