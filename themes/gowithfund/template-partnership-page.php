<?php
/*
Template Name: Partner Single Page
*/
get_header();
?>
<style>
    .buttonhovercss > a{
            padding: 10px 30px 10px 30px;
            border-radius: 20px;
            background: #00A9A5!important;
    }
</style>
<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <section class="thank-you">
            <header class="page-header">
                <h1 class="page-title" style="text-align: center; font-size: 60px; color: #00A9A5; padding-top: 3rem;"><?php esc_html_e('Title', 'krowd'); ?></h1>
            </header>
            <div class="page-content">
                <p style="text-align: center;"><?php esc_html_e('Description ', 'krowd'); ?></p>
                <h4>Key Feature</h4>
                <ul>
                    <li>Key 1</li>
                    <li>Key 1</li>
                    <li>Key 1</li>
                    <li>Key 1</li>
                </ul>
            </div>

        </section>
    </main>
</div>

<?php
get_footer();
?>
    