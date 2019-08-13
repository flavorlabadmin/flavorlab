<?php
/*
 Template Name: Homepage
*/

 // Default category for the work menu for this section
 $defaultCategoryId = 4;

?>

<?php get_header(); ?>

      <?php include_once('includes/SIDEBAR-FLHome.php'); ?>

      <div id="content">

        <div id="inner-content">

            <main id="main" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">

              <!-- Category Switch -->
              <div class="catSwitchContainer">
                <div class="catSwitchInner">
                  <ul class="workCategories">
                 <?php
                  $args = array('orderby' => 'name','order' => 'ASC', 'child_of' =>  $defaultCategoryId);
                  $categories = get_categories($args);
                  $count = 1;
                  foreach ($categories as $category) {
                    echo '<li class="'.$category->category_nicename.'" id="cat'.$category->cat_ID.'">'.$category->name.'</li>';
                    $count++;
                  }
                 ?>
                  </ul>
                </div>
                <div class="close"></div>
              </div>

              <!-- Slider -->
              <div id="work" class="topSlider">
                <div class="sliderBG"></div>
                <div class="sliderInner">

                  <div class="catLeft"></div>
                  <div class="catRight"></div>

                  <div class="categorySwitch">LOADING...</div>

                  <div id="workTop">
                    <div id="iframeContainer">
                      <iframe src="" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                    </div>

                    <div id="expand">CLICK TO READ MORE</div>
                    <div id="workExpand">
                      <div id="workClose"></div>
                      <div class="inner">
                        <h1>Loading</h1>
                        <h2></h2>
                        <p></p>
                        <a href="#" class="caseStudyLink">VIEW FULL CASE STUDY</a>
                      </div>
                    </div>

                    <div id="postSelector" class="flexslider">
                      <ul class="slides">
                        <li></li>
                      </ul>
                    </div>

                    <div class="swipeMore">&laquo; Swipe to see more &raquo;</div>

                  </div><!--  // Work Top -->

                </div><!--  // Slider inner -->
              </div><!--  // topSlider -->

              <!-- About -->
              <?php $page_id = 9; $page_data = get_page( $page_id ); $image = wp_get_attachment_url( get_post_thumbnail_id($page_id)); ?>
              <div class="section" id="about">
                <div class="sectionInner" style="background: url(<?php echo $image ?>) top center no-repeat; background-size:cover;">
                  <?php echo apply_filters('the_content', $page_data->post_content); ?>
                </div>
              </div>

              <!-- Services f/k/a Companies -->
              <?php $page_id = 11; $page_data = get_page( $page_id ); $image = wp_get_attachment_url( get_post_thumbnail_id($page_id)); ?>
              <div class="section" id="services" style="background: #ecf0f1 url(<?php echo $image ?>) top center no-repeat;">
                <div class="sectionInner">
                  <?php echo apply_filters('the_content', $page_data->post_content); ?>
                </div>
              </div>

              <!-- Team -->
              <?php $page_id = 13; $page_data = get_page( $page_id ); $image = wp_get_attachment_url( get_post_thumbnail_id($page_id)); ?>
              <div class="section" id="team" style="background: url(<?php echo $image ?>.jpg) center center no-repeat; background-size:cover;">
                <div class="sectionInner">
                  <?php echo apply_filters('the_content', $page_data->post_content); ?>
                </div>
                <div id="teamMembers" class="flexslider">
                  <div class="swipeMore">&laquo; Swipe to see more &raquo;</div>

                  <ul class="slides">
                  <?php query_posts('cat=19'); if (have_posts()) : while (have_posts()) : the_post(); $image = wp_get_attachment_url( get_post_thumbnail_id($the_ID)); $withoutExt = preg_replace('/\\.[^.\\s]{3,4}$/', '', $image);?>
                    <li>
                      <div class="expClose">X</div>
                      <div class="hoverDetails">
                        <h1><?php the_title(); ?></h1>
                        <h2><?php echo get_post_meta($post->ID, 'team-position', true); ?></h2>
                      </div>
                      <div class="expand">
                        <h1><?php the_title(); ?></h1>
                        <h2><?php echo get_post_meta($post->ID, 'team-position', true); ?></h2>
                        <?php the_content() ?>
                      </div>
                      <img src="<?php echo $withoutExt; ?>.jpg" alt ="<?php the_title(); ?>"/>
                    </li>
                  <?php endwhile; endif; ?>
                  </ul>
                </div>
              </div>
              
              <!-- Testimonials -->
              <?php $page_id = 6869; $page_data = get_page( $page_id ); ?>
              <div class="section" id="testimonials">
                <div class="sectionInner">
                  <?php echo apply_filters('the_content', $page_data->post_content); ?>
                <div id="testimonialSlides" class="flexslider">
                  <div class="swipeMore">&laquo; Swipe to see more &raquo;</div>

                  <ul class="slides">
                  <?php query_posts('cat=2168'); if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <li>
                         <div class="quote-wrapper"><div class="laurel left">v</div><?php the_content() ?><div class="laurel right">w</div></div>
                    </li>
                  <?php endwhile; endif; ?>
                  </ul>
                </div>
                </div>
              </div>

            </main>

              <!-- Contact -->
              <?php $page_id = 158; $page_data = get_page( $page_id ); $image = wp_get_attachment_url( get_post_thumbnail_id($page_id)); ?>
              <div class="section" id="contact" style="background: url(<?php echo $image ?>) top center no-repeat; background-size:cover;">
                <div class="sectionInner">
                  <?php  echo apply_filters('the_content', $page_data->post_content); ?>
                </div>
              </div>

        </div>

        <a href="#0" class="cd-top">Top</a>
      </div>

      <footer class="footer" role="contentinfo" itemscope itemtype="http://schema.org/WPFooter">
        <div id="inner-footer">
          <img src="<?php echo get_template_directory_uri(); ?>/library/images/footerlogo.png" alt="Flavorlab" />
          <p>212.673.2773<br/><a class="mail-us" href="mailto:booking@flavorlab.com"><span data-title="booking@flavorlab.com">Email Booking</span></a></p>
        </div>
      </footer>

<?php get_footer(); ?>
