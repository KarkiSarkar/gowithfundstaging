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
                        <p style="text-align: center;"><?php esc_html_e('Thank you for your submission. We will get back to you soon.', 'krowd'); ?></p>
                    </div>
                </section>
            </main>
        </div>

        <?php
        get_footer();
        ?>