<?php
/*
Template Name: Partner Single Page
*/
get_header();
?>

    <main id="main" class="container-layout-content container">
        <section>
            <header class="page-header">
                <h1 class="page-title"><?php the_title(); ?></h1>
            </header>
            <div class="page-content">
                <p><?php //the_field('description');?></p>
                <h4>Key Feature</h4>
                <ul>
                    <li>Key 1</li>
                    <li>Key 1</li>
                    <li>Key 1</li>
                    <li>Key 1</li>
                </ul>
            </div>
            <div style="background: #00A9A5;">
                <?php echo do_shortcode('[custom_contact_form]'); ?>
            </div>

        </section>
    </main>

<?php
get_footer();
?>
    