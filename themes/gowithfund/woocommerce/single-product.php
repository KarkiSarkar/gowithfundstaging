<?php
/**
 * The Template for displaying all single products.
 *
 * Override this template by copying it to yourtheme/woocommerce/single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
	get_header(); 
  
	$page_id = krowd_id();

	$default_sidebar_config = krowd_get_option('product_sidebar_config', ''); 
	$default_left_sidebar = krowd_get_option('product_left_sidebar', ''); 
	$default_right_sidebar = krowd_get_option('product_right_sidebar', ''); 

	$sidebar_layout_config = get_post_meta($page_id, 'krowd_sidebar_config', true);
	$left_sidebar = get_post_meta($page_id, 'krowd_left_sidebar', true);
	$right_sidebar = get_post_meta($page_id, 'krowd_right_sidebar', true);

	if ($sidebar_layout_config == "") {
		$sidebar_layout_config = $default_sidebar_config;
	}
	if ($left_sidebar == "") {
		$left_sidebar = $default_left_sidebar;
	}
	if ($right_sidebar == "") {
		$right_sidebar = $default_right_sidebar;
	}

	$left_sidebar_config  = array('active' => false);
   $right_sidebar_config = array('active' => false);
   $main_content_config  = array('class' => 'col-lg-12 col-xs-12');

	$sidebar_config = krowd_sidebar_global($sidebar_layout_config, $left_sidebar, $right_sidebar);
   
	extract($sidebar_config);

 ?>

<section id="wp-main-content" class="clearfix main-page">
    <?php
      /**
       * woocommerce_before_main_content hook
       *
       * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
       * @hooked woocommerce_breadcrumb - 20
       */
      do_action( 'woocommerce_before_main_content' );
    ?>
    
   <div class="container">	
   	 <div class="main-page-content row">
         <div class="content-page <?php echo esc_attr($main_content_config['class']); ?>">      
           
     			<?php while ( have_posts() ) : the_post(); ?>

     				<?php wc_get_template_part( 'content', 'single-product' ); ?>

     			<?php endwhile; // end of the loop. ?>
     				
         </div>      

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

      </div>   
   </div>

    <?php
      /**
       * woocommerce_after_main_content hook
       *
       * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
       */
      do_action( 'woocommerce_after_main_content' );
    ?>

    <div class="related-section">
      <div class="container">
        <?php woocommerce_output_related_products() ?>
      </div>
    </div>
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
    <div style="display: flex; justify-content: space-between;" class="container custom-donate-section ">
        <div style="display: flex;">
            <div style="height: 100px; width: 100px;">
                <?php echo woocommerce_get_product_thumbnail(); ?>
            </div>
            <div>
                <h2 class="woocommerce-loop-product__title"><?php echo $product->get_name(); ?></h2>
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
	.custom-donate-section {
    display: none; /* Initially hidden */
    position: fixed;
    bottom: 10px;
    right: 10px;
    background: white;
    padding: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
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