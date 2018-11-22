    </div>


    <?php // all js scripts are loaded in library/bones.php ?>

    <script type='text/javascript'>

      jQuery(document).ready(function($) {
        // Page detect
        var is_home = $('body').hasClass('home');
        var is_single = $('body').hasClass('single');
        var is_score = $('body').hasClass('page-template-page-score');
        var is_sound = $('body').hasClass('page-template-page-sound');
        var is_ptb = $('body').hasClass('page-template-page-producerstoolbox');

        category_name = getUrlParameter('category');

        // If we don't have the category, grab them from the FL settings page. These are the category slug names, with hyphens and all lower case.
        if(typeof category_name === 'undefined') {
          if(is_home) category_name = '<?php echo get_option('FLHomepageDefaultWorkCat'); ?>';
          if(is_score) category_name = '<?php echo get_option('FLScoreDefaultWorkCat'); ?>';
          if(is_sound) category_name = '<?php echo get_option('FLSoundDefaultWorkCat'); ?>';
          if(is_ptb) category_name = '<?php echo get_option('FLPTBDefaultWorkCat'); ?>';
        }

      });

      var category_id = null, post_id = null;
      var ajaxurl = "<?php echo admin_url( 'admin-ajax.php' ); ?>";
      var topSliderAction = 'fl_slider_latestTopWork';
      var topSliderSecurity = '<?php echo wp_create_nonce( 'fl_slider_latestTopWork-security' ); ?>';
      var thumbNailSecurity = '<?php echo wp_create_nonce( 'fl_slider_thumbnailLoad-security' ); ?>';

    </script>

    <?php wp_footer(); ?>



  </body>
</html>
