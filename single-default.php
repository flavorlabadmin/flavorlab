<?php get_header(); ?>
  <?php include('includes/HEADER-nav-menus.php'); ?>
<?php include_once('includes/SIDEBAR-FLHome.php'); ?>

  <div id="content" class="workPost">
  	<?php if (have_posts()) : while (have_posts()) : the_post(); $image = get_post_meta($post->ID, 'artistSpotlightBackground', $single = true);?>
    <div id="inner-content" class="postContent x" style="background: black url(<?php echo $image; ?>) top center no-repeat; background-size:cover;">
        <main id="main" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">
<header class="entry-header article-header"><?php //the_post_thumbnail( '' ); ?>
<h1 class="single-title custom-post-type-title"><?php the_title(); ?></h1></header>
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