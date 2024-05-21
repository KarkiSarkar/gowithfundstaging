<?php
/*
Template Name: Partner Single Page
*/
get_header();
?>

    <main id="main" class="container-layout-content container">
        <section>
            <header class="page-header">
                <h1 class="page-title"><?php esc_html_e('Title', 'krowd'); ?></h1>
            </header>
            <div class="page-content">
                <p><?php esc_html_e('Description ', 'krowd'); ?></p>
                <h4>Key Feature</h4>
                <ul>
                    <li>Key 1</li>
                    <li>Key 1</li>
                    <li>Key 1</li>
                    <li>Key 1</li>
                </ul>
            </div>
            <div>
                <?php echo do_shortcode('[custom_contact_form]'); ?>
            </div>

        </section>
    </main>

<?php
get_footer();
?>
    