<?php get_header(); ?>


       <script>
       // wrap videos in containter
      jQuery(document).ready(function($) {
      $( "iframe" ).wrap( "<div id='iframeContainer'></div>" );
      });
      </script>

      <?php include('includes/HEADER-nav-menus.php'); ?>
 <?php include_once('includes/SIDEBAR-FLHome.php'); ?>

      <div id="content">
      

      	<?php if (have_posts()) : while (have_posts()) : the_post(); $image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>
        <div id="inner-content" class="postContent" style="background: white;">
            <main id="main" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">
<header class="entry-header article-header"><?php //the_post_thumbnail( '' ); ?>
<h1 class="single-title custom-post-type-title x"><?php the_title(); ?></h1></header>
						<?php the_content('Read more...'); ?>
						<?php endwhile; ?>
						<?php else : ?>
							<article id="post-not-found" class="hentry cf">
									<header class="article-header">
										<h1><?php _e( 'Oops, Post Not Found!', 'bonestheme' ); ?></h1>
									</header>
									<section class="entry-content">
										<p><?php _e( 'Uh Oh. Something is missing. Try double checking things.', 'bonestheme' ); ?></p>
									</section>
									<footer class="article-footer">
										<p><?php _e( 'If you keep having difficulties pop us an email using the contact link in the header and let us know what is going on. Much appreciated!', 'bonestheme' ); ?></p>
									</footer>
							</article>
              <?php if (in_category('motoID')){ ?>
                <div class="alignleft"><?php previous_post_link('&laquo; %link','%title',TRUE,'') ?></div>
                <div class="alignright"><?php next_post_link('%link &raquo;','%title',TRUE,'') ?></div>
              <?php }
              else { ?>
                <div class="alignleft"><?php previous_post_link('&laquo; %link','%title','','motoID') ?></div>
                <div class="alignright"><?php next_post_link('%link &raquo;','%title','','motoID') ?></div>
              <?php } ?>
						<?php endif; ?>
            </main>
        </div>
      </div>
<?php get_footer(); ?>

     