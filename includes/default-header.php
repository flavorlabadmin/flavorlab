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
            <?php //include('HEADER-SocialMediaLinks.php'); ?>
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

<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-529e25a354797f0c" async="async"></script>
      <div id="sidebar">
        <p>Our Companies:</p>
        <nav class="sitesSubNav" role="navigation" itemscope itemtype="http://schema.org/SiteNavigationElement">
          <?php wp_nav_menu(array(
           'container' => false,                           // remove nav container
           'container_class' => '',                        // class of container (should you choose to use it)
           'menu' => __( 'Site Navigation', 'bonestheme' ),// nav name
           'menu_class' => '',                             // adding custom nav class
           'theme_location' => 'sites-nav',                // where it's located in the theme
           'before' => '',                                 // before the menu
           'after' => '',                                  // after the menu
           'link_before' => '',                            // before each link
           'link_after' => '',                             // after each link
           'depth' => 0,                                   // limit the depth of the nav
           'fallback_cb' => ''                             // fallback function (if there is one)
          )); ?>

        </nav>
      </div>