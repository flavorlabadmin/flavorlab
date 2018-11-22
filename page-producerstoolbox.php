<?php
/*
 Template Name: Flavorlab Producer's Toolbox Homepage Template
*/

 $defaultCategoryId = 61;

?>

<?php get_header(); ?>

      <?php include_once('includes/SIDEBAR-PTB.php'); ?>

      <div id="content">

        <div id="inner-content">

            <main id="main" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">

              <!-- Category Switch -->
              <div id="work" class="catSwitchContainer">
                <div class="catSwitchInner">
                  <ul class="workCategories">
                   <?php
                    $args = array('orderby' => 'name','order' => 'ASC', 'child_of' =>  $defaultCategoryId);
                    $categories = get_categories($args);
                    $count = 1;
                    foreach ($categories as $category) {
                      $fullCatName = $category->name;
                      $cleanCatName = str_replace("FLScore", "", $fullCatName);
                      $cleanCatName = str_replace("FLSound", "", $cleanCatName);
                      $cleanCatName = str_replace("Producerstoolbox", "", $cleanCatName);
                      echo '<li class="'.$category->category_nicename.'" id="cat'.$category->cat_ID.'">'.$cleanCatName.'</li>';
                      $count++;
                    }
                   ?>
                  </ul>
                </div>
                <div class="close"></div>
              </div>

              <!-- Slider -->
              <div class="topSlider">
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
              <?php $page_id = 267; $page_data = get_page( $page_id ); $image = wp_get_attachment_url( get_post_thumbnail_id($page_id)); ?>
              <div class="section" id="about">
                <div class="sectionInner" style="background: url(<?php echo $image ?>) top center no-repeat; background-size:cover;">
                  <?php echo apply_filters('the_content', $page_data->post_content); ?>
                </div>
              </div>

              <!-- Brands -->
              <?php $page_id = 458; $page_data = get_page( $page_id ); $image = wp_get_attachment_url( get_post_thumbnail_id($page_id)); ?>
              <div class="section" id="brands" style="background: url(<?php echo $image ?>) top center no-repeat; background-size:cover;">
                <div class="sectionInner">
                  <?php echo apply_filters('the_content', $page_data->post_content); ?>
                </div>
              </div>

              <!-- Artist Spotlight -->
              <?php $page_id = 303; $page_data = get_page( $page_id ); $image = wp_get_attachment_url( get_post_thumbnail_id($page_id)); ?>
              <div class="section" id="artist-spotlight" style="background: #000 url(<?php echo $image ?>) top center no-repeat;">
                <div class="sectionInner">
                  <?php echo apply_filters('the_content', $page_data->post_content); ?>

                  <div class="artistSpotlight">
                  <?php query_posts('cat=76&posts_per_page=4'); if (have_posts()) : while (have_posts()) : the_post(); $image = wp_get_attachment_url( get_post_thumbnail_id($the_ID)); $withoutExt = preg_replace('/\\.[^.\\s]{3,4}$/', '', $image); ?>
                    <div class="post" style="background: url(<?php echo $withoutExt; ?>.jpg) 0 0 no-repeat; ">
                      <a href="<?php echo the_permalink(); ?>?c=ptb" alt="<?php echo the_title(); ?>">
                        <span><?php the_title(); ?></span>
                      </a>
                    </div>
                  <?php endwhile; endif; ?>
                  </div>

                </div>
              </div>

              <!-- Submit -->
              <?php $page_id = 309; $page_data = get_page( $page_id ); $image = wp_get_attachment_url( get_post_thumbnail_id($page_id)); ?>
              <div class="section" id="submit-section" style="background: #000 url(<?php echo $image ?>) top center no-repeat; background-size: cover;">
                <div class="sectionInner">
                  <?php echo apply_filters('the_content', $page_data->post_content); ?>
                </div>
              </div>

              <!-- Contact -->
              <?php $page_id = 381; $page_data = get_page( $page_id ); $image = wp_get_attachment_url( get_post_thumbnail_id($page_id)); ?>
              <div class="section" id="contact" style="background: url(<?php echo $image ?>) top center no-repeat; background-size:cover;">
                <div class="sectionInner">
                  <?php  echo apply_filters('the_content', $page_data->post_content); ?>
                </div>
              </div>

            </main>

        </div>

        <a href="#0" class="cd-top">Top</a>
      </div>

      <footer class="footer" role="contentinfo" itemscope itemtype="http://schema.org/WPFooter">
        <div id="inner-footer">
          <img src="<?php echo get_template_directory_uri(); ?>/library/images/footerlogo.png" alt="Flavorlab" />
          <p>212.673.2773<br/><a class="mail-us" href="mailto:licensing@producerstoolbox.com"><span data-title="licensing@flavorlab.com">Email Licensing</span></a></p>
        </div>
      </footer>

<?php get_footer(); ?>
