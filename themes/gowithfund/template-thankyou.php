<?php
/*
Template Name: Thank You Page
*/
get_header();
?>
<style>
    .not-found-wrapper {
    padding: 300px 0 250px;
    background: url('https://images.unsplash.com/photo-1502082553048-9b3a9d6a2f61') repeat-x center center transparent;
    background-size: cover;
}
</style>
<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <section class="thank-you">
            
            <div class="not-found-wrapper text-center">
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