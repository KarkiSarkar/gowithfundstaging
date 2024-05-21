<?php
/*
Template Name: Partner Single Page
*/
get_header();
$form = get_field('form_shortcode');
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
            <!-- <div style="display: flex;"> -->
                <div class="page-content" style="">
                    <p><?php the_field('description');?></p>
                </div>
                <div style="">
                <?php
                    if ( has_post_thumbnail() ) {
                        the_post_thumbnail('full'); // 'full' can be changed to 'thumbnail', 'medium', 'large', etc. based on your needs
                    }
                    ?>

                </div>
            <!-- </div> -->
            <div class="page-content" style="padding-right: 10px;">
            <h4>Key Feature</h4>
                <p><?php the_field('key_feature');?></p>
            </div>
            <div style="background: #00A9A5; width: 60%; padding-top: 3rem; margin: auto;">
                <?php echo do_shortcode($form); ?>
            </div>
            
        </section>
    </main>

<?php
get_footer();
?>
    