<?php
/*
Template Name: Archives
*/
/**
 * 
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @author Heath Taskis | http://fdthemes.com
 * @package Stream 0.1
 */

get_header(); ?>
  <div class="jumbotron archive-jt" style="">
      <div class="container">
        <h1 class="entry-title"><?php single_month_title(); ?></h1>

      </div>
    </div>  
	<div class="container">
		<div class="row">
			<div class="col-md-8">
				<section id="primary" class="content-area">
					<main id="main" class="site-main" role="main">
			
                        <div id="primary" class="clearfix">

                          <!--BEGIN #primary-blog .hfeed-->
                          <div id="primary-blog" class="hfeed"> 

                                    <div class="archive-col">   
                                        <form method="get" id="arch-searchform" action="<?php echo home_url(); ?>/">
                                                      <input type="text" class="archive-search" value="" placeholder="Type something & hit enter to search" name="s" id="s">
                                                      
                                        </form>
                                    </div>       
                          <?php $check_arch = get_the_title(); ?>
                                    
                          <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                            
                            <!--BEGIN .hentry -->
                            <div <?php post_class(); ?> id="post-<?php the_ID(); ?>">       
                                    

                                                   
       
                                    <!--BEGIN .entry-content -->
                                    <div class="entry-content-archive">
                                        <?php if ($check_arch != "Archives"){  
                                          get_template_part('content', get_post_format());
                                        } ?>
                   
                                        <!--BEGIN .archive-lists -->
                                
                                        
                                    <!--END .entry-content -->
                                    </div>
                                      
                                      
                            <!--END .hentry-->  
                            </div>
                    
                            <?php endwhile; ?>
                    
                          <?php else : ?>
                    
                            <!--BEGIN #post-0-->
                            <div id="post-0" <?php post_class(); ?>>
                            
                              <h4 class="page-title"><?php _e('Error 404 - Not Found', 'framework') ?></h4>
                            
                              <!--BEGIN .entry-content-->
                              <div class="entry-content">
                                <p><?php _e("Sorry, but you are looking for something that isn't here.", "framework") ?></p>
                              <!--END .entry-content-->
                              </div>
                            
                            <!--END #post-0-->
                            </div>
                    
                          <?php endif; ?>
                          

  
			
					</main><!-- #main -->
				</section><!-- #primary -->
			</div><!-- .col-md-8 -->
			
			<div class="col-md-4">
                          <div class="archive-lists">
                                      <h3><?php _e('Last 20 Posts', 'framework') ?></h3>
                                      
                                      <ul class="list-group">
                                        <?php $archive_20 = get_posts('numberposts=20');
                                        foreach($archive_20 as $post) : ?>
                                          <li> <a  href="<?php the_permalink(); ?>"><?php the_title();?></a></li>
                                        <?php endforeach; ?>
                                      </ul>
                                    </div>
                                      <h3><?php _e('Archives by Month', 'framework') ?></h3>
                                      <ul class="list-group">
                                        <?php wp_get_archives('type=monthly'); ?>
                                      </ul>
                                      <h3><?php _e('Categories', 'framework') ?></h3>
                                      <ul class="list-group">
                                        <?php wp_list_categories( 'title_li=' ); ?>
                                      </ul>
                                      <h3><?php _e('Authors', 'framework') ?></h3>
                                      <ul class="list-group">
                                        <?php wp_list_authors( 'title_li=' ); ?>
                                      </ul>                                      

                                </div>
                                <!--END .archive-lists -->
			</div><!-- .col-md-4 -->
		</div><!-- .row -->
	</div><!-- .container -->
<?php get_footer(); ?>
