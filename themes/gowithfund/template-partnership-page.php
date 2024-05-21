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
                <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>
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
    