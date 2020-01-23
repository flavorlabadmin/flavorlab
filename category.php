<?php get_header(); ?>
	<?php include('includes/HEADER-nav-menus.php'); ?>
  <?php //include_once('includes/SIDEBAR-FLHome.php'); ?>
  <?php if ( is_category('56') ) { include_once('includes/SIDEBAR-Score.php'); 
      				} elseif ( is_category('86') ) { include_once('includes/SIDEBAR-Sound.php');
      				} elseif ( is_category('87') ) { include_once('includes/SIDEBAR-PTB.php'); 
      				} else { include_once('includes/SIDEBAR-FLHome.php'); }?>
	<div id="content" class="blogCategory">
		<div id="inner-content" class="wrap cf">
			<div id="catContainer">
				<h1 class="head">FLAVOR<span>NEWS</span></h1>
				<main id="main" class="m-all t-2of3 d-5of7 cf" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">
					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					<article id="post-<?php the_ID(); ?>" <?php post_class( 'cf' ); ?> role="article">
						<header class="entry-header article-header">
							<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail( 'flavorlab-960' ); ?></a>
							<h3 class="entry-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
						</header>
						<section class="entry-content cf"> 
							<?php the_date() ?> <?php the_excerpt( '<span class="read-more">' . __( 'MORE', 'bonestheme' ) . '</span>' ); ?>
						</section>
					</article>
					<?php endwhile; ?>
							<?php bones_page_navi(); ?>
					<?php else : ?>
							<article id="post-not-found" class="hentry cf">
								<header class="article-header">
									<h1><?php _e( 'Oops, Post Not Found!', 'bonestheme' ); ?></h1>
								</header>
								<section class="entry-content">
									<p><?php _e( 'Uh Oh. Something is missing. Try double checking things.', 'bonestheme' ); ?></p>
								</section>
								<footer class="article-footer">
										<p><?php _e( 'This is the error message in the archive.php template.', 'bonestheme' ); ?></p>
								</footer>
							</article>
					<?php endif; ?>
				</main>
				<?php get_sidebar(); ?>
			</div>
		</div>
			</div>
<?php get_footer(); ?>
