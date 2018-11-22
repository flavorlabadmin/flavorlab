<?php get_header(); ?>

      <?php include('includes/HEADER-nav-menus.php'); ?>

			<div id="content">

				<div id="inner-content" class="wrap cf">

          <div id="catContainer">

					<main id="main" class="m-all t-2of3 d-5of7 cf" role="main">
						<h1 class="archive-title"><span><?php _e( 'Search Results for:', 'bonestheme' ); ?></span> <?php echo esc_attr(get_search_query()); ?></h1>

						<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

							<article id="post-<?php the_ID(); ?>" <?php post_class('cf'); ?> role="article">

								<header class="entry-header article-header">

									<h3 class="search-title entry-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>

								</header>

								<section class="entry-content">
										<?php the_excerpt( '<span class="read-more">' . __( 'MORE', 'bonestheme' ) . '</span>' ); ?>

								</section>

							</article>

						<?php endwhile; ?>

								<?php bones_page_navi(); ?>

							<?php else : ?>

									<article id="post-not-found" class="hentry cf">
										<header class="article-header">
											<h1><?php _e( 'Sorry, No Results.', 'bonestheme' ); ?></h1>
										</header>
										<section class="entry-content">
											<p><?php _e( 'Dang! We couldn\'t find anything! Try searching for something else, or get in contact with us so we can help you out!', 'bonestheme' ); ?></p>
										</section>
									</article>

							<?php endif; ?>

						</main>

							<?php get_sidebar(); ?>

          </div>

				</div>

			</div>

<?php get_footer(); ?>
