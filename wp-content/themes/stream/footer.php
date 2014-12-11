<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 * 
 *
 * @author Heath Taskis | http://fdthemes.com
 * @package Stream 0.1
 */
?>

	</div><!-- #content -->

	<div class="footer-wrap">
		<div class="container">
			<div class="row">

				<div class="footer-widget col-xs-6 col-md-3">

					<?php 				if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer Slot 1')) : 
					endif; ?>

				</div>
				<div class="footer-widget col-xs-6 col-md-3">

					<?php 				if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer Slot 2')) : 
					endif; ?>
					
				</div>
				<div class="footer-widget col-xs-6 col-md-3">

					<?php 				if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer Slot 3')) : 
					endif; ?>
						
				</div>	
				<div class="footer-widget col-xs-6 col-md-3">

					<?php 				if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer Slot 4')) : 
					endif; ?>
						
				</div>										
			</div>	
		</div>
	</div>	
</div><!-- #page -->




<?php wp_footer(); ?>
</body>
</html>