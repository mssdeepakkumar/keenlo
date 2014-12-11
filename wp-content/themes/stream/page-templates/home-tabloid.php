<?php
/**
 * Template Name: Home - Tabloid
 * The template used for displaying page content in page.php
 *
 * @author Heath Taskis | http://f-d.com.au
 * @package FD 0.1
 */
get_header(); 
/*
**
**
**
Featured Slider
**
**
**
*/
	            
?>
<!-- masterslider -->
<?php
  $feat_post = new WP_Query();
  $feat_post->query('category_name=Featured&orderby=rand'); 

  if ( $feat_post->have_posts() ) {
  echo '<div class="master-slider ms-skin-default " id="masterslider">';
  while ($feat_post->have_posts()) : $feat_post->the_post();
  $header_img = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); 
  ?>
    <!-- new slide -->
    <div class="ms-slide" data-delay="5">
        <!-- slide background -->
        <img src="<?php echo $header_img[0]; ?>" style="display:none;"/>
        <div style="background-image: url(<?php echo $header_img[0]; ?>); background-size: cover; background-position: center;" >
          <div style="padding-top: 650px; min-height: 400px;"></div>
        </div>  
        <!-- slide text layer -->
        <div class="ms-layer ms-caption">
        	<span class="readtime">	
					<?php 
					if( function_exists( 'post_read_time' ) ) {
						echo '<i class="icon-bookmark" style="margin-right: 5px;"></i>';
						post_read_time();
					} ?>
			</span>
        	<h2 class="rounded">FEATURED</h2>

        	<a href="<?php echo the_permalink(); ?>" style="text-decoration:none;">
           	<h1 style="" class="ms-h1"><?php echo the_title(); ?></h1></a>
           	<div class="lead">
           		<?php echo the_excerpt(); ?>
           	</div>
			<a href="<?php echo the_permalink(); ?>" target="_self"><button class="homeCta">Read More</button></a>
        </div>
    </div>
    <!-- end of slide -->
<?php	

$do_not_duplicate = $post->ID;
endwhile; 

//If slider boxed or fullwidth
$slider_toggle =  get_theme_mod('themeslug_slider'); 
if($slider_toggle != 'value1'){ 
	echo '</div>'; //row
	echo '</div>';//container;
	echo '</div>';//marquee wrap;	
}; 

echo '
	</div>
	<!-- end of masterslider -->
	 ';
};

wp_reset_postdata();
wp_enqueue_script( 'masterslider-settings-js', get_template_directory_uri().'/js/masterslider.settings.js',array(),'20131031',true);    
?>

<!--
**
**
**
        Category Tabs
**
**
**
-->

	<div class="cat-tabs-wrapper" >
		<div class="container">
			<div class="row">
		<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Above Content')) : ?>

		<?php endif; ?>					
				<div class="col-md-12">	
					<ul id="myTab" class="nav nav-tabs">
        			<?php
					
					$catnav =  get_theme_mod('themeslug_catnav'); 

        			if($catnav != 'value1'){
/*
						$args = array('theme_location' => 'catnav', 
									  'container_class' => 'nav nav-tabs', 
									  'menu_class' => 'nav nav-tabs',
									  'fallback_cb' => '',
			                          'menu_id' => 'myTab',

			                          'walker' => new Upbootwp_Walker_Nav_Menu()); 
						wp_nav_menu($args); */


$menu_name = 'catnav'; //e.g. primary-menu; $options['menu_choice'] in your case

if (($locations = get_nav_menu_locations()) && isset($locations[$menu_name])) {
    $menu = wp_get_nav_menu_object($locations[$menu_name]);
    $menu_items = wp_get_nav_menu_items($menu->term_id);
}
$i = 0;
foreach ($menu_items as $menu_item) {
    $id = $menu_item->ID;
    $catslug = $menu_item->title;
    $title = $menu_item->title;
    $url = $menu_item->url;
    
	$catslug = strtolower($catslug);

	$catslug = str_replace(" ", "-", $catslug);  

	if($i == 0){
		echo '<li class="active nt-click"><a href="#' .$catslug. '" data-toggle="tab">'.$title.'</a></li>';      
	}else{
		echo '<li class="nt-click"><a href="#' .$catslug. '" data-toggle="tab">'.$title.'</a></li>';  	
	}
	$i++;
    if ($parent_id = $menu_item->menu_item_parent) {
        //the element has a parent with id $parent_id, so you can build a hierarchically menu tree

    }
    else {
        //the element doesn't have a parent
    }
}

        			}else{

			           	 $args = array (

			                'hierarchical ' => 0

			            );

			            $cats = get_categories( $args ); //meooowww!!

			 			$i = 0;

			            foreach ( (array)$cats as $cat) {

			            	$thisCat = $cat->name;
			            	$thisCatSlug = $cat->slug;

							$thisCat = preg_replace('/[^A-Za-z0-9]/', "", $thisCat);
							

							if($thisCat != 'Featured'){


				            	if($i == 0){
				              	  echo '<li class="active nt-click"><a href="#' .$thisCatSlug. '" data-toggle="tab">'.$cat->name.'</a></li>';                
				            	}else{
				             	   echo '<li class="nt-click"><a href="#' .$thisCatSlug. '" data-toggle="tab">'.$cat->name.'</a></li>';              		
				            	}

				            	$i++;

				            	}
							}
					}
		            ?>
					</ul>	
				</div>
			</div>
		</div>	
	</div>
	<div class="container" >
	<div class="row">
		<div  class="tab-content home-tabs">
		<?php
		if($catnav != 'value1'){
			$menu_name = 'catnav'; //e.g. primary-menu; $options['menu_choice'] in your case

			if (($locations = get_nav_menu_locations()) && isset($locations[$menu_name])) {
			    $menu = wp_get_nav_menu_object($locations[$menu_name]);
			    $menu_items = wp_get_nav_menu_items($menu->term_id);
			}
			$i = 0;
				foreach ($menu_items as $menu_item) {
				    $id = $menu_item->ID;
				    $catslug = $menu_item->title;
				    $title = $menu_item->title;
				    $url = $menu_item->url;
				    
					$catslug = strtolower($catslug);

					$catslug = str_replace(" ", "-", $catslug);  

					query_posts('showposts=5&category_name='.$catslug );

					if($catslug != 'Featured'){
						if($i == 0){
							echo '<div class="tab-pane fade in active" id="' .$catslug. '">';
						}else{
							echo '<div class="tab-pane fade " id="' .$catslug. '">';	
						}

						$i++;
				        echo '<div class="col-md-8 col-lg-8">
							  	<div id="primary" class="content-area">
									<main id="main" class="site-main" role="main">';

												 if ( have_posts() ) : ?>
												
													<?php while ( have_posts() ) : the_post(); ?>
										
														<?php  // if( $post->ID == $do_not_duplicate ) continue;
															/* Include the Post-Format-specific template for the content.
															 * If you want to override this in a child theme, then include a file
															 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
															 */
															get_template_part('content', 'tabloid');
															
															$do_not_duplicate = $post->ID;
														?>
										
													<?php endwhile; ?>
										
													<?php 
													//upbootwp_content_nav('nav-below'); 
													echo '<section class="view-all">';
													echo '<a href="'.$url.'"><button class="homeCta" style="cursor:pointer; margin: 15px 0;">More '.$title.' </button></a>';
													echo '</section><!-- .no-results -->';
													?>							
													<?php else : ?>
														<?php get_template_part( 'no-results', 'index' ); ?>
													<?php endif; ?>
						
									</main><!-- #main -->
								</div><!-- #primary -->
							</div><!-- .col-md-8 -->
						</div><!-- .tab pane -->
						<?php
				   		if ($parent_id = $menu_item->menu_item_parent) {
	        			//the element has a parent with id $parent_id, so you can build a hierarchically menu tree

					    }
					    else 
					    {
	       				 //the element doesn't have a parent
	    			}
				}//for each
			}
		}else{ //if $catnav

            $args2 = array (

                'hierarchical ' => 0

            );

            $cats2 = get_categories( $args2 ); //meooowww!!

 			$l = 0;

            foreach ($cats2 as $cat2) {

            	$thisCat2 = $cat2->name;
            	$thisCat2Slug = $cat2->slug;            	

				$thisCat2 = preg_replace('/[^A-Za-z0-9]/', "", $thisCat2);


				query_posts('showposts=5&category_name='.$thisCat2Slug );


			if($thisCat2 != 'Featured'){
				if($l == 0){
					echo '<div class="tab-pane fade in active" id="' .$thisCat2Slug. '">';
				}else{
					echo '<div class="tab-pane fade " id="' .$thisCat2Slug. '">';	
				}
			$l++;



	        echo '<div class="col-md-8 col-lg-8">
				  	<div id="primary" class="content-area">
						<main id="main" class="site-main" role="main">';

									 if ( have_posts() ) : ?>
									
										<?php while ( have_posts() ) : the_post(); ?>
							
											<?php  // if( $post->ID == $do_not_duplicate ) continue;
												/* Include the Post-Format-specific template for the content.
												 * If you want to override this in a child theme, then include a file
												 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
												 */
												get_template_part('content', 'tabloid');
												
												$do_not_duplicate = $post->ID;
											?>
							
										<?php endwhile; ?>
							
										<?php 
										
										$category_link = get_category_link( $cat2->name );

										//upbootwp_content_nav('nav-below'); 
										echo '<section class="view-all">';
										echo '<a href="'.get_category_link( $cat2->term_id ).'"><button class="homeCta" style="cursor:pointer; margin: 15px 0;">More '.$thisCat2.' </button></a>';
										echo '</section><!-- .no-results -->';
										?>
							
										<?php else : ?>
											<?php get_template_part( 'no-results', 'index' ); ?>
										<?php endif; ?>
			
						</main><!-- #main -->
					</div><!-- #primary -->
				</div><!-- .col-md-8 -->
			
			</div>
			<?php
			}
			} // for each
			}			
			?>
			<div id="sidebar" class="col-md-4 col-lg-4">
				<?php get_sidebar(); ?>	
			</div><!-- .col-md-4 -->
		</div><!-- .row -->
	</div><!-- .container -->
		<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Below Blog/Index')) : ?>
		<?php endif; ?>	

<?php get_footer(); ?>