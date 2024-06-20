<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * Override this template by copying it to yourtheme/woocommerce/content-single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>

<?php

	/**
	 * woocommerce_before_single_product hook
	 *
	 * @hooked wc_print_notices - 10
	 */
	 do_action( 'woocommerce_before_single_product' );

	 if ( post_password_required() ) {
	 	echo get_the_password_form();
	 	return;
	 }
	 
	 // prev & next post -------------------
	 $post_prev = get_adjacent_post(false, '', true);
	 $post_next = get_adjacent_post(false, '', false);
	 $shop_page_id = wc_get_page_id( 'shop' );
	 
	 // post classes -----------------------
	 $classes = array();
	 $classes[] = 'product-single-main';
	 
?>

<div id="product-<?php the_ID(); ?>" <?php post_class( $classes ); ?>>
	<div class="product-wrapper clearfix">
		
		<div class="product-single-inner row">
			<div class="column col-md-6 col-sm-12 col-xs-12 product_image_wrapper">
				<div class="column-inner">
					<div class="image_frame scale-with-grid">
						<?php
							/**
							 * woocommerce_before_single_product_summary hook
							 *
							 * @hooked woocommerce_show_product_sale_flash - 10
							 * @hooked woocommerce_show_product_images - 20
							 */
							do_action( 'woocommerce_before_single_product_summary' );	
						?>
					</div>
					<?php do_action( 'woocommerce_product_thumbnails' ); ?>
				</div>	
			</div>

			<div class="column col-md-6 col-sm-12 col-xs-12 summary entry-summary">
				<div class="column-inner clearfix">
					<div class="menu-single-product">
						<?php
							next_post_link( '%link',  '<i class="fas fa-chevron-left"></i>' , true, array(), 'product_cat' );
							previous_post_link( '%link',  '<i class="fas fa-chevron-right"></i>', true, array(), 'product_cat' );
						?>
					</div>
					<?php
						/**
						 * woocommerce_single_product_summary hook
						 *
						 * @hooked woocommerce_template_single_title - 5
						 * @hooked woocommerce_template_single_rating - 10
						 * @hooked woocommerce_template_single_price - 10
						 * @hooked woocommerce_template_single_excerpt - 20
						 * @hooked woocommerce_template_single_add_to_cart - 30
						 * @hooked woocommerce_template_single_meta - 40
						 * @hooked woocommerce_template_single_sharing - 50
						 */
						do_action( 'woocommerce_single_product_summary' );
						
						if(is_active_sidebar( 'woocommerce_single_summary' )){
							dynamic_sidebar( 'woocommerce_single_summary' );
						}
					?>
					
				</div>
			</div>	
		</div>
	</div>
	
	<?php
		/**
		 * woocommerce_after_single_product_summary hook
		 *
		 * @hooked woocommerce_output_product_data_tabs - 10
		 * @hooked woocommerce_output_related_products - 20
		 */
		
		do_action( 'woocommerce_after_single_product_summary' );
	?>

	<meta itemprop="url" content="<?php the_permalink(); ?>" />

</div><!-- #product-<?php the_ID(); ?> -->
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
<?php do_action( 'woocommerce_after_single_product' ); ?>
