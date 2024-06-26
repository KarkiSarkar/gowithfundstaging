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