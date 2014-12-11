<?php
/**
 * The Header for my theme.
 *
 * Displays all of the <head> section and everything up till <main id="main">
 * 
 *
 * @author Heath Taskis | http://byheath.com
 * @package Knews 0.1
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>

	<meta charset="<?php bloginfo( 'charset' ); ?>">

	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title><?php wp_title( '|', true, 'right' ); ?></title>

	<link rel="profile" href="http://gmpg.org/xfn/11">

	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<?php 
	if ( is_singular() ) wp_enqueue_script( "comment-reply" );
	wp_enqueue_script("jquery");
	wp_head(); ?>

</head>

<?php get_template_part('customizer', 'index'); 
?>

<body <?php body_class(); ?>>

<div id="search">

    <form method="get" id="searchform" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">

		<div class="search-close"><i class="icon-plus"></i></div>

		<label id="label" for="searchtext">search <?php echo get_bloginfo(); ?> </label>

		<input id="searchtext" name="s" type="text" autocomplete="off" value="<?php echo esc_attr( get_search_query() ); ?>" id="s" placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'wpex' ); ?>" />    
	
	</form>

</div>

<div class="secondary-nav-wrap">

	<div class="container ">

		<div class="row ">		
						<?php 
						$args = array('theme_location' => 'secondary', 
									  'container_class' => 'secondary-navbar', 
									  'menu_class' => 'secondary-navbar-nav',
									  'fallback_cb' => '',
			                          'menu_id' => 'secondary-nav',
			                          'walker' => new Upbootwp_Walker_Nav_Menu()); 
						wp_nav_menu($args);
						?>
		</div>

	</div>

</div>

<div id="page" class="hfeed site">
	<?php do_action( 'before' ); ?>

	<header id="masthead" class="site-header container" role="banner">

		<nav class="navbar navbar-default navbar-fixed-top" role="navigation">

			<div class="container">

				<div class="row">

					<div class="col-md-12">

						<div class="search-cta">

							<div class="mag-circle"></div><div class="mag-line"></div>

						</div>

				        <div class="navbar-header">

				            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">

					            <span class="icon-bar bar-one"></span>
					            <span class="icon-bar bar-two"></span>
					            <span class="icon-bar bar-three"></span>

							</button> 

							<?php if ( get_theme_mod( 'themeslug_logo' ) ) : ?>

							    <div class='site-logo'>

							        <a href='<?php echo esc_url( home_url( '/' ) ); ?>' title='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>' rel='home'><img src='<?php echo esc_url( get_theme_mod( 'themeslug_logo' ) ); ?>' alt='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>'></a>
							    
							    </div>

							<?php else : ?>

							    <hgroup>
							        <a href='<?php echo esc_url( home_url( '/' ) ); ?>' title='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>' class='navbar-brand' rel='home'><?php bloginfo( 'name' ); ?></a>      
							    </hgroup>

							<?php endif; ?>	

					    </div>						
						<?php 
						$args = array('theme_location' => 'primary', 
									  'container_class' => 'navbar-collapse collapse', 
									  'menu_class' => 'nav navbar-nav',
									  'fallback_cb' => '',
			                          'menu_id' => 'main-menu',
			                          'walker' => new Upbootwp_Walker_Nav_Menu()); 
						wp_nav_menu($args);
						?>   

					</div><!-- .col-md-12 -->

				</div><!-- row -->

			</div><!-- container -->

		</nav>

	</header><!-- #masthead -->

	<div id="content" class="site-content">

		<?php
		if ( is_front_page() ) {
	        $slider_toggle =  get_theme_mod('themeslug_slider'); 
	        if($slider_toggle != 'value1'){ 

	        echo	
	        '<div class="marquee-wrap">
	        	<div class="container">
						<div class="row">';
			
		} }
