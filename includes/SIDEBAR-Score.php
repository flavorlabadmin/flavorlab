      <div id="sidebar" style="padding-top: 40px;">
        <a href="<?php bloginfo('url'); ?>" rel="nofollow" id="headerLogo">Flavorlab</a>
        <!--<p>Main menu:</p>-->
        <nav class="main-nav" role="navigation" itemscope itemtype="http://schema.org/SiteNavigationElement">
        <nav class="sitesSubNav" role="navigation" itemscope itemtype="http://schema.org/SiteNavigationElement">
          <?php wp_nav_menu(array(
           'container' => false,                           // remove nav container
           'container_class' => '',                 // class of container (should you choose to use it)
           'menu' => __( 'Site Navigation', 'bonestheme' ),  // nav name
           'menu_class' => '',               // adding custom nav class
           'theme_location' => 'sites-nav',                 // where it's located in the theme
           'before' => '',                                 // before the menu
           'after' => '',                                  // after the menu
           'link_before' => '',                            // before each link
           'link_after' => '',                             // after each link
           'depth' => 0,                                   // limit the depth of the nav
           'fallback_cb' => ''                             // fallback function (if there is one)
          )); ?>

        </nav>
        <?php

        if ( has_nav_menu( 'flscore-nav' ) ) {
            wp_nav_menu( array(
                'theme_location' => 'flscore-nav',
                'items_wrap'     => '<ul>%3$s</ul>',
                'walker'  => new Walker_Nav_Menu_Dropdown()));
        }

        ?>
        </nav>
      </div>