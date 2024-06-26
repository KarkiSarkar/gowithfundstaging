<?php
defined( 'ABSPATH' ) || exit;

get_header(); 

$page_id = krowd_id();

$default_sidebar_config = krowd_get_option('product_sidebar_config', ''); 
$default_left_sidebar = krowd_get_option('product_left_sidebar', ''); 
$default_right_sidebar = krowd_get_option('product_right_sidebar', ''); 

$sidebar_layout_config = get_post_meta($page_id, 'krowd_sidebar_config', true);
$left_sidebar = get_post_meta($page_id, 'krowd_left_sidebar', true);
$right_sidebar = get_post_meta($page_id, 'krowd_right_sidebar', true);

$sidebar_layout_config = empty($sidebar_layout_config) ? $default_sidebar_config : $sidebar_layout_config;
$left_sidebar = empty($left_sidebar) ? $default_left_sidebar : $left_sidebar;
$right_sidebar = empty($right_sidebar) ? $default_right_sidebar : $right_sidebar;

$left_sidebar_config  = array('active' => false);
$right_sidebar_config = array('active' => false);
$main_content_config  = array('class' => 'col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12');

$sidebar_config = krowd_sidebar_global($sidebar_layout_config, $left_sidebar, $right_sidebar);

extract($sidebar_config);

$percent_display = $percent = wpcf_function()->get_raised_percent(); if( $percent >= 100 ){ $percent = 100; }

$total = wpcf_function()->get_total_fund($page_id);
$goal = wpcf_function()->get_total_goal($page_id);
if ($total > 0 && $goal > 0  ) {
   $percent_display =  number_format($total / $goal * 100, 2, '.', '');
}

$funding_goal = get_post_meta($post->ID, '_nf_funding_goal', true);
$raised = 0;
$total_raised = wpcf_function()->get_total_fund();
if ($total_raised){
   $raised = $total_raised;
}

$days_remaining = apply_filters('date_expired_msg', esc_html__('0', 'krowd'));
if (wpcf_function()->get_date_remaining()){
   $days_remaining = apply_filters('date_remaining_msg', esc_html__(wpcf_function()->get_date_remaining() . '', 'krowd'));
}

$end_method = get_post_meta(get_the_ID(), 'wpneo_campaign_end_method', true);

do_action( 'wpcf_before_single_campaign' );

global $post, $product;

if ( post_password_required() ) {
   echo get_the_password_form();
   return;
}
?>

<section id="wp-main-content" class="clearfix main-page">

   <?php do_action( 'woocommerce_before_main_content' ); ?>

   <div class="container-full"> 
      <div class="main-page-content product-type-crowdfunding">
         
         <!-- Content Page -->
         <div class="content-page">      

            <div class="wpneo-list-details">
               
               <?php while ( have_posts() ) : the_post(); ?>
                  <?php do_action( 'wpcf_before_main_content' ); ?>
                     
                  <div itemscope itemtype="http://schema.org/ItemList" id="campaign-<?php the_ID(); ?>" <?php post_class(); ?>>
                     <div class="campaign-top">
                        <div class="container">
                           <div class="row">
                              
                              <div class="col-xl-7 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                 <?php do_action( 'wpcf_before_single_campaign_summary' ); ?>
                              </div> 

                              <div class="col-xl-5 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                 <div class="campaign-single-summary campaign-single-right">
                                    <div class="wpneo-campaign-summary-inner" itemscope itemtype="http://schema.org/DonateAction">
                                       
                                       <div class="campaign-meta clearfix">
                                          <div class="campaign-categories">
                                             <?php echo wc_get_product_category_list( $product->get_id(), ' | ', '<span class="posted_in">' . _n( '', '', count( $product->get_category_ids() ), 'krowd' ) . ' ', '</span>' ); ?>
                                          </div>
                                          <?php wpcf_function()->template('include/location'); ?>
                                       </div>
                                          
                                       <h2 class="wpneo-campaign-title"><?php the_title(); ?></h2>
                                       
                                       <div class="campaign-info <?php echo 'end_method-' . esc_attr($end_method) ?>">
                                          <div class="campaign-pledged info-item">
                                             <span class="info-value"><?php echo wc_price($raised); ?></span>
                                             <span class="info-label"><?php echo esc_html__( 'Pledged', 'krowd' ) ?></span>
                                          </div>
                                          <div class="campaign-backers info-item">
                                             <span class="info-value"><?php echo wpcf_function()->get_total_backers(); ?></span>
                                             <span class="info-label"><?php echo esc_html__( 'Backers', 'krowd' ) ?></span>
                                          </div>
                                          <?php if ($end_method != 'never_end'){ ?>
                                             <div class="camapign-time_remaining info-item">
                                                <?php wpcf_function()->template('include/loop/time_remaining'); ?>
                                             </div>
                                          <?php } ?>
                                       </div>

                                       <!-- Campaign Raised -->
                                       <div class="campaign-raised clearfix">
                                          <div class="campaign-raised-label"><?php echo esc_html__('Raised: ', 'krowd') ?></div>
                                          <div class="campaign-percent_raised"><?php echo esc_html($percent_display); ?>%</div>
                                       </div>
                                       <div class="campaign-progress clearfix">
                                          <div class="progress">
                                             <div class="progress-bar" data-progress-animation="<?php echo esc_attr($percent)?>%">
                                                <span class="percentage"><span></span></span>
                                             </div>
                                          </div>
                                       </div>
                                       <!-- End Campaign Raised -->

                                       <div class="campaign-goal">
                                          <span class="label-goal"><?php echo esc_html__('Goal:', 'krowd'); ?></span>
                                          <span class="value-goal"><?php echo wc_price( $funding_goal ); ?></span>
                                       </div> 

                                       <?php wpcf_function()->template('include/fund-campaign-btn'); ?>

                                       <?php wpcf_function()->template('include/creator-info'); ?>
                                    </div>
                                 </div>
                              </div>  

                           </div>

                        </div>
                     </div>         
                     
                     <div class="campaign-bottom">
                        <div class="container">
                           <div class="row">

                              <!-- Main content -->
                              <div class="<?php echo esc_attr($main_content_config['class']); ?>">
                                 <?php do_action( 'wpcf_after_single_campaign_summary' ); ?>
                                 <meta itemprop="url" content="<?php the_permalink(); ?>" />
                              </div>  
                              <!-- End Main content -->

                              <!-- Left sidebar -->
                              <?php if($left_sidebar_config['active']): ?>
                                 <div class="sidebar wp-sidebar sidebar-left <?php echo esc_attr($left_sidebar_config['class']); ?>">
                                    <?php do_action( 'krowd_before_sidebar' ); ?>
                                    <div class="sidebar-inner">
                                       <?php dynamic_sidebar($left_sidebar_config['name'] ); ?>
                                    </div>
                                    <?php do_action( 'krowd_after_sidebar' ); ?>
                                 </div>
                              <?php endif ?>
                              <!-- End Left sidebar -->

                              <!-- Right Sidebar -->
                              <?php if($right_sidebar_config['active']): ?>
                                 <div class="sidebar wp-sidebar sidebar-right <?php echo esc_attr($right_sidebar_config['class']); ?>">
                                    <?php do_action( 'krowd_before_sidebar' ); ?>
                                       <div class="sidebar-inner">
                                          <?php dynamic_sidebar($right_sidebar_config['name'] ); ?>
                                       </div>
                                    <?php do_action( 'krowd_after_sidebar' ); ?>
                                 </div>
                              <?php endif ?>
                              <!-- End Right sidebar -->

                           </div>   
                        </div>   
                     </div> 

                     <?php get_template_part('wpcftemplate/woocommerce/basic/related' ); ?>
                            
                  </div>

                  <?php do_action( 'wpcf_after_single_campaign' ); ?>
                  <?php do_action( 'wpcf_after_main_content' ); ?>

               <?php endwhile;  ?>

            </div>
         </div>
         <!-- Content Page -->

      </div>
   </div>   

   <?php //do_action( 'woocommerce_after_main_content' ); ?>

</section>
<?php
defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
    return;
}
?>
<div <?php wc_product_class( '', $product ); ?>>
    <div class="container custom-donate-section additiobnal" style="display: flex;">
        <div style="display: flex;">
            <div style="height: 50px; width: 50px;">
                <?php echo woocommerce_get_product_thumbnail(); ?>
            </div>
            <div>
                <p class="woocommerce-loop-product__title"><?php echo $product->get_name(); ?></p>
            </div>
        </div>
        <div>
		<form class="cart" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post" enctype="multipart/form-data">
                <button type="submit" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" class="single_add_to_cart_button button alt">Donate</button>
            </form>
        </div>
    </div>
</div>
<style>
   @media only screen and (max-width: 800px) {
      .additiobnal{
         display: flex; 
         justify-content: space-between!important; 
         border: 1px solid #00A9A5!important; 
         box-shadow: 2px 2px 5px #00A9A5!important;
         width: 100%!important;
      }
      .woocommerce-loop-product__title{
      font-size: 12px; 
      padding-left: 10px; 
      font-weight: 600;
   }
      .custom-donate-section {
  
    position: fixed!important;
    bottom: 0px!important;
    right: 0px!important;
    background: white!important;
    padding: 10px!important;
    
    z-index: 9999!important;
}
   }  
   .woocommerce-loop-product__title{
      font-size: 18px; 
      padding-left: 10px; 
      font-weight: 600;
   }
   .additiobnal{
      display: flex; 
      justify-content: space-between; 
      border: 3px solid #00A9A5; 
      width: 35%;
      box-shadow: 2px 2px 5px #00A9A512;
   }
	.custom-donate-section {
    display: none; /* Initially hidden */
    position: fixed;
    bottom: 10px;
    right: 10px;
    background: white;
    padding: 10px;
    z-index: 9999;
}
</style>
<script>
	jQuery(document).ready(function($) {
    // Listen for the click event on the Add to Cart button
    // $(document).on('click', '.single_add_to_cart_button', function() {
    //     // Trigger a click on the custom button
    //     $('.wpneo_donate_button').click();
    // });

    function isElementInViewport(el) {
        var rect = el.getBoundingClientRect();
        return (
            rect.top >= 0 &&
            rect.left >= 0 &&
            rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
            rect.right <= (window.innerWidth || document.documentElement.clientWidth)
        );
    }

    function checkVisibility() {
        var addToCartButton = document.querySelector('.wpneo-campaign-title');
        var customDonateSection = document.querySelector('.custom-donate-section');
        
        if (addToCartButton && customDonateSection) {
            if (!isElementInViewport(addToCartButton)) {
                $(customDonateSection).fadeIn();
            } else {
                $(customDonateSection).fadeOut();
            }
        }
    }

    // Check visibility on scroll and on page load
    $(window).on('scroll', checkVisibility);
    $(window).on('load', checkVisibility);
	$(document).on('submit', '.cart', function(event) {
        event.preventDefault(); // Prevent the default form submission
        var form = $(this);
        $.post(form.attr('action'), form.serialize(), function(response) {
            window.location.href = "<?php echo esc_url( wc_get_checkout_url() ); ?>"; // Redirect to checkout page
        });
    });
	
});

</script>
<?php get_footer(); ?>