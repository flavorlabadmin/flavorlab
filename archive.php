<?php get_header(); ?>


      <header class="header" role="banner" itemscope itemtype="http://schema.org/WPHeader">

        <div id="inner-header">
          <div id="headerTop">
            <div id="siteTag">
              <div id="nav-icon">
                <span></span>
                <span></span>
                <span></span>
                <span></span>
              </div>
              <span><?php bloginfo('description'); ?></span>
            </div>
            <!--<a href="<?php bloginfo('url'); ?>" rel="nofollow" id="headerLogo"><?php bloginfo('name'); ?></a>-->
            <?php //include('includes/HEADER-SocialMediaLinks.php'); ?>
 <?php echo get_option('fl_homepage_socialmedia'); ?>
          </div>
          
<?php if ( !is_front_page() ) : ?>

          <nav class="subNav" role="navigation" itemscope itemtype="http://schema.org/SiteNavigationElement">
            <?php wp_nav_menu(array(
             'container' => false,                           // remove nav container
             'container_class' => 'menu cf',                 // class of container (should you choose to use it)
             'menu' => __( 'Sub Page Top Nav', 'bonestheme' ),  // nav name
             'menu_class' => 'nav top-nav cf',               // adding custom nav class
             'theme_location' => 'subpage-nav',              // where it's located in the theme
             'before' => '',                                 // before the menu
             'after' => '',                                  // after the menu
             'link_before' => '',                            // before each link
             'link_after' => '',                             // after each link
             'depth' => 0,                                   // limit the depth of the nav
             'fallback_cb' => ''                             // fallback function (if there is one)
            )); ?>
          </nav>
<?php else : ?>
          <nav class="subNav" role="navigation" itemscope itemtype="http://schema.org/SiteNavigationElement">
            <?php wp_nav_menu(array(
             'container' => false,                           // remove nav container
             'container_class' => 'menu cf',                 // class of container (should you choose to use it)
             'menu' => __( 'The Main Menu', 'bonestheme' ),  // nav name
             'menu_class' => 'nav top-nav cf',               // adding custom nav class
             'theme_location' => 'main-nav',                 // where it's located in the theme
             'before' => '',                                 // before the menu
             'after' => '',                                  // after the menu
             'link_before' => '',                            // before each link
             'link_after' => '',                             // after each link
             'depth' => 0,                                   // limit the depth of the nav
             'fallback_cb' => ''                             // fallback function (if there is one)
            )); ?>
          </nav>
<?php endif; ?>

        </div>

      </header>

      <?php include_once('includes/SIDEBAR-FLHome.php'); ?>

			<div id="content" class="archive">

				<div id="inner-content" class="wrap cf">

					<div id="catContainer">
            <h1 class="head">FLAVOR<span>BLOG</span></h1>
						<main id="main" class="m-all t-2of3 d-5of7 cf" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">
							<?php
							the_archive_title( '<h1 class="page-title">', '</h1>' );
							the_archive_description( '<div class="taxonomy-description">', '</div>' );
							?>
							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
							<article id="post-<?php the_ID(); ?>" <?php post_class( 'cf' ); ?> role="article">
								<header class="entry-header article-header">
									<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail( 'flavorlab-960' ); ?></a>
									<h3 class="h2 entry-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
								</header>
								<section class="entry-content cf">
									<?php the_excerpt( '<span class="read-more">' . __( 'MORE', 'bonestheme' ) . '</span>' ); ?>
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