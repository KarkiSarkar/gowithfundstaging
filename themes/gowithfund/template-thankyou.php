<?php
/*
Template Name: Thank You Page
*/
get_header();
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <section class="thank-you">
            
            <div class=" text-center">
			<div class="not-found-title"><h1><span><?php esc_html_e('Thank You', 'krowd'); ?></span></h1></div>
			<!-- <div class="not-found-subtitle">Page Not Found</div> -->
			<div class="not-found-desc"><?php esc_html_e('Thank you for your request on becoming a partner. We will get back to you soon.', 'krowd'); ?></div> 

			<div class="not-found-home text-center">
				<a href="https://dev.gowithfund.com/"><i class="far fa-arrow-alt-circle-left"></i>Back Homepage</a>
			</div>
		</div>

        </section>
    </main>
</div>

<?php
get_footer();
?>
        
<script>
// JavaScript to redirect to home page when the Thank You page is refreshed
// window.onload = function() {
//     if(performance.navigation.type == 1) {
//         window.location.href = '<?php echo esc_url( home_url( '/become-a-partner' ) ); ?>';
//     }
// }
</script>