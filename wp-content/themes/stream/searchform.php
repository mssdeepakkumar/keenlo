<?php
/**
 * The template for displaying search forms in Stream
 * 
 *
 * @author Heath Taskis | http://fdthemes.com
 * @package Stream 0.1
 */
?>
<form role="search" method="get" class="search-form form-inline" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div class="form-group">
		<input type="search" class="search-field form-control" placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'upbootwp' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" name="s" title="<?php _ex( 'Search for:', 'label', 'upbootwp' ); ?>">
	</div>
	<input type="submit" class="search-submit btn btn-default" value="<?php echo esc_attr_x( 'Search', 'submit button', 'upbootwp' ); ?>">
</form>
