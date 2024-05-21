<?php
/*
Template Name: Partner Single Page
*/
get_header();
?>
<style>
    .page-title{
        padding-top: 3rem;
    }
</style>
    <main id="main" class="container-layout-content container">
        <section>
            <header class="page-header">
                <h1 class="page-title"><?php the_title(); ?></h1>
            </header>
            <div style="display: flex;">
            <div class="page-content" style="width: 48%;">
                <p><?php the_field('description');?></p>
            </div>
            <div style="width: 48%;">
            <?php
                if ( has_post_thumbnail() ) {
                    the_post_thumbnail('full'); // 'full' can be changed to 'thumbnail', 'medium', 'large', etc. based on your needs
                }
                ?>

            </div>
            
            <div style="background: #00A9A5; width: 70%; padding-top: 3rem;">
                <?php echo do_shortcode('[custom_contact_form]'); ?>
            </div>

        </section>
    </main>

<?php
get_footer();
?>
    