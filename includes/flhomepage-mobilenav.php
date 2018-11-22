          <nav class="mobileSubNav" role="navigation" itemscope itemtype="http://schema.org/SiteNavigationElement">
          <?php

          if ( has_nav_menu( 'main-nav' ) ) {
              wp_nav_menu( array(
                  'theme_location' => 'main-nav',
                  'items_wrap'     => '<select id="drop-nav"><option value="">Main Menu</option>%3$s</select>',
                  'walker'  => new Walker_Nav_Menu_Dropdown()));
          }

          ?>
          </nav>