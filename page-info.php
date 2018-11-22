<?php
/*
 Template Name: Info
*/
?>

<?php get_header(); ?>

<?php include_once('includes/SIDEBAR-FLHome.php'); ?>

      <div id="content">

      	<?php if (have_posts()) : while (have_posts()) : the_post(); $image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>
        <div id="inner-content" class="postContent" style="background: black url(<?php echo $image ?>) top center no-repeat; background-size:cover;">

            <main id="main" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">
						<h1 class=""><?php the_title(); ?></h1>
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

						<?php endif; ?>

            </main>

        </div>

      </div>

<?php get_footer(); ?>