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
            <div>
            <?php echo do_shortcode('[simple_form]'); ?>
            </div>
            
        </section>
    </main>
<script>
    FB.api(
  '/484103824186469/events',
  'POST',
  {"data":"[{\"action_source\":\"website\",\"event_id\":12345,\"event_name\":\"TestEvent\",\"event_time\":1716434206,\"user_data\":{\"client_ip_address\":\"254.254.254.254\",\"client_user_agent\":\"Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:63.0) Gecko/20100101 Firefox/63.0\",\"em\":\"f660ab912ec121d1b1e928a0bb4bc61b15f5ad44d5efdc4e1c92a25e99b8e44a\"}}]","test_event_code":"TEST86831"},
  function(response) {
      // Insert your code here
  }
);
</script>
<?php
get_footer();
?>
    