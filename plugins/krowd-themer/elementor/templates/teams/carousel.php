<?php
   $query = $this->query_posts();
   $_random = gaviasthemer_random_id();
   if ( ! $query->found_posts ) {
      return;
   }

   $this->add_render_attribute('wrapper', 'class', ['gva-teams-carousel']);

   $this->add_render_attribute('wrapper', 'data-filter', $_random);

   $this->add_render_attribute('carousel', 'class', 'init-carousel-owl owl-carousel');
  
  ?>

   <div <?php echo $this->get_render_attribute_string('wrapper'); ?>>
      <div <?php echo $this->get_render_attribute_string('carousel') ?> <?php echo $this->get_carousel_settings() ?>>
          <?php
              global $post;
              $count = 0;
              while ( $query->have_posts() ) { 
              $query->the_post();
                  $post->loop = $count++;
                  $post->post_count = $query->post_count;
                  $data = array(
                    'settings'  => $settings
                  );
                  $this->krowd_get_template_part('templates/content/item', $settings['style'], $data );
              }
          ?>
      </div>
   </div>
  <?php
  wp_reset_postdata();