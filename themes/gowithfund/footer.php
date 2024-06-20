<?php
/**
 * $Desc
 *
 * @author     Gaviasthemes Team     
 * @copyright  Copyright (C) 2020 gaviasthemes. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 * 
 */
?>
	</div><!--end page content-->
	
</div><!-- End page -->
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
	<footer id="wp-footer" class="clearfix">
		
		<?php $footer = apply_filters('krowd_get_footer_layout', null );?>

		<?php 
			if(!empty($footer) && $footer != '__disable_footer' && class_exists('Gavias_Themer_Footer')){
				if($footer != '__default'){
					echo '<div class="footer-main">' .  Gavias_Themer_Footer::getInstance()->render_footer_builder($footer)  . '</div>'; 
				}else{
					get_template_part('templates/parts/footer-widgets');
				}
			}else{
				get_template_part('templates/parts/footer-widgets');
			}
		?>
		<?php if(krowd_get_option('copyright_default', 'yes') == 'yes'){ 
			$copyright = krowd_get_option('copyright_text', ''); ?>

			<div class="copyright">
				<div class="container">
					<div class="copyright-content">
							<div class="row">
								<div class="col-sm-12 col-xs-12">
									<?php 
										if(!empty($copyright)){ 
											echo esc_html($copyright);
										}else{
											echo esc_html__('Copyright 2020 - Company - All rights reserved. Powered by WordPress.', 'krowd');
										}
									?>
								</div>
							</div>	
						</div>	
				</div>
			</div>
		<?php } ?>	

		<?php if( krowd_get_option('enable_backtotop', false) ){ ?>
			<div class="return-top default"><i class="far fa-arrow-alt-circle-up"></i></div>
		<?php } ?>

	</footer>
	
	<div id="gva-overlay"></div>
	<div id="gva-quickview" class="clearfix"></div>
	<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="blur-svg">
	   <defs>
	      <filter id="blur-filter">
	         <feGaussianBlur stdDeviation="3"></feGaussianBlur>
	      </filter>
	    </defs>
	</svg>

<script async src="https://www.googletagmanager.com/gtag/js?id=G-0ZCYSLL5K1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'G-0ZCYSLL5K1');
</script>




<?php wp_footer(); ?>
</body>
</html>