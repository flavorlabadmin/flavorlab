




































    // INIT TOP SLIDER
    jQuery(document).ready(function($) {

      
      //
      // Nav anchors animation + activation
      //
      $('#menu-main-menu li:first-child a').addClass('active');
      $(document).on("scroll", onScroll);

      $('#menu-main-menu a[href^="#"]').on('click', function (e) {
          e.preventDefault();
          $(document).off("scroll");
          
          $('a').each(function () { $(this).removeClass('active'); });
          $(this).addClass('active');
        
          var target = this.hash,
              menu = target;
          $target = $(target);
          $('html, body').stop().animate({
              'scrollTop': $target.offset().top - 99
          }, 600, 'easeInOutQuart', function () {
              window.location.hash = target;
              $(document).on("scroll", onScroll);
          });
      });
      function onScroll(event){
        setTimeout(function(){
          var scrollPos = $(document).scrollTop();
          $('#menu-main-menu a').each(function () {
              var currLink = $(this);
              var refElement = $(currLink.attr("href"));
              if (refElement.position().top-99 <= scrollPos && refElement.position().top + refElement.height() > scrollPos) {
                  $('#menu-main-menu a').removeClass("active");
                  currLink.addClass("active");
              }
              else{
                  currLink.removeClass("active");
              }
          });
        }, 500);
      }

      //
      // Init Top Slider
      //
      $('#postSelector').flexslider({
        animation: "slide",
        slideshow: false,
        animationSpeed: 400,
        itemWidth: 146,
        itemMargin: 20,
        animationLoop: true,
        touch: true
      });

      //
      // Load latest post in Direct From Brands category
      //
      ajaxurl = "<?php echo admin_url( 'admin-ajax.php' ); ?>";
      var data = {
        action: 'fl_slider_latestTopWork',
        security: "<?php echo wp_create_nonce( 'fl_slider_latestTopWork-security' ); ?>",
        category_id: 5
      };

      
      jQuery.post(ajaxurl, data, function(response) {
        var json = jQuery.parseJSON(response);
        $.each(json, function(key, item) {
          $('#iframeContainer').children('iframe').attr('src', json[0]['vimeoURL']);
          $('#workExpand').children('.inner').html('<h1>'+json[0]['post_title']+'</h1><h2>'+json[0]['date']+' | '+json[0]['clientName']+'</h2><p>'+json[0]['post_excerpt']+'</p><a href="'+json[0]['fullLink']+'">VIEW FULL CASE STUDY</a>');
          $('.topSlider').css('background-image','url('+json[0]['featured_image_url']+')');
        });

      }); // END Load latest post in Direct From Brands category


      // Load subsequent posts into slider
      ajaxurl = "<?php echo admin_url( 'admin-ajax.php' ); ?>";
      var data = {
        action: 'fl_slider_latestSlider',
        security: "<?php echo wp_create_nonce( 'fl_slider_latestSlider-security' ); ?>",
        category_id: 5
      };
      
      // Remove first item - flex glitches without a default slide
      $('#postSelector').data('flexslider').removeSlide(0);

      jQuery.post(ajaxurl, data, function(response) {
        var json = jQuery.parseJSON(response);
        var data = json, post;
        for( var i = 0; i < data.length; i++ ) {
          post = data[i];
          var html = '<li class="post-'+post['post_id']+'">'+post['featured_image']+'</li>';
          $('#postSelector').data('flexslider').addSlide(html);
        }

        $('#postSelector li:first-child').addClass('active');

      }); // END Load subsequent posts into slider

      // END INIT SLIDER











      //
      // Category menu switching
      //
      $(".workCategories li").click(function(e) {

        $('.workCategories li').removeClass('active');
        $(this).addClass('active');

        // Close category box
        $('.catSwitchContainer').css('visibility', 'visible');
        var eleH = $('.catSwitchContainer').height();
        $('.catSwitchContainer').animate({ 'top': -eleH-100}, 300);

        // Get Category number
        var eleID = $(this).attr('id').split(' ').pop();
        var eleID = eleID.replace("cat", "");

        // Remove, add new category name
        $('.categorySwitch').text('');
        var catName = $(this).text();
        $('.categorySwitch').text(catName);

        // Get latest top post
        ajaxurl = "<?php echo admin_url( 'admin-ajax.php' ); ?>";
        var data = {
          action: 'fl_slider_latestTopWork',
          security: "<?php echo wp_create_nonce( 'fl_slider_latestTopWork-security' ); ?>",
          category_id: eleID
        };
        
        jQuery.post(ajaxurl, data, function(response) {
          var json = jQuery.parseJSON(response);
          $.each(json, function(key, item) { 

            $('#iframeContainer').children('iframe').attr('src', json[0]['vimeoURL']).delay(800);
            $('#workExpand').children('.inner').html('<h1>'+json[0]['post_title']+'</h1><h2>'+json[0]['date']+' | '+json[0]['clientName']+'</h2><p>'+json[0]['post_excerpt']+'</p><a href="'+json[0]['fullLink']+'">VIEW FULL CASE STUDY</a>');
            $('.topSlider').css('background-image','url('+json[0]['featured_image_url']+')');

          });

        }); // End get latest top post

        // Load all other associated category posts in post slider
        ajaxurl = "<?php echo admin_url( 'admin-ajax.php' ); ?>";
        var data = {
          action: 'fl_slider_latestSlider',
          security: "<?php echo wp_create_nonce( 'fl_slider_latestSlider-security' ); ?>",
          category_id: eleID
        };
        
        jQuery.post(ajaxurl, data, function(response) {
          var json = jQuery.parseJSON(response);
          var data = json, post;

          // Remove all existing category slides
          $('#postSelector').data('flexslider').removeSlide(0);
          var slider = $('#postSelector');
          while (slider.data('flexslider').count > 0) slider.data('flexslider').removeSlide(0);

          // Add new slides on clicked category
          for( var i = 0; i < data.length; i++ ) {
            post = data[i];
            var html = '<li class="post-'+post['post_id']+'">'+post['featured_image']+'</li>';
            $('#postSelector').data('flexslider').addSlide(html);
          }

          $('#postSelector li:first-child').addClass('active');

        }); // END Load subsequent posts into slider


      }); // Work Categories 










      //
      // Individual thumbnail clicks
      //
      $('#postSelector .slides').on('click', 'li', function() {

          // Get post ID
          var eleClass = $(this).attr('class').split(' ').pop();
          var eleClass = eleClass.replace("post-", "");

          // Load clicked thumbnail into main area
          ajaxurl = "<?php echo admin_url( 'admin-ajax.php' ); ?>";
          var data = {
            action: 'fl_slider_thumbnailLoad',
            security: "<?php echo wp_create_nonce( 'fl_slider_thumbnailLoad-security' ); ?>",
            post_id: eleClass
          };
          
          jQuery.post(ajaxurl, data, function(response) {
            var json = jQuery.parseJSON(response);
            $('#iframeContainer').children('iframe').attr('src', json[0]['vimeoURL']);
            $('#workExpand').children('.inner').html('<h1>'+json[0]['post_title']+'</h1><h2>'+json[0]['date']+' | '+json[0]['clientName']+'</h2><p>'+json[0]['post_excerpt']+'</p><a href="'+json[0]['fullLink']+'">VIEW FULL CASE STUDY</a>');
            $('.topSlider').css('background-image','url('+json[0]['featured_image_url']+')');

            $('html, body').animate({ scrollTop: 0 }, 300);

          });

          // Toggle active thumbnail classes
          $('.slides li').removeClass('active');
          $(this).addClass('active');

      }); // Thumbnail click











      //
      // LEFT Category arrow click
      //

      $('.catLeft').click(function(e) {

          // Get current category by nav class & load previous category top and thumbnails
          $( ".catSwitchInner li" ).each(function() {
            if ($(this).hasClass("active")) {

              var prevCat = $(this).prev().attr('id');

              if(typeof prevCat !== "undefined"){

                // Get & set Category number & title
                var prevCatName = $(this).prev().text();

                // Remove, add new category name
                $('.categorySwitch').text('');
                $('.categorySwitch').text(prevCatName);

                $( ".catSwitchInner li" ).removeClass('active');
                $('#' + prevCat).addClass('active');

                //
                // Load previous cat in top area
                //
                ajaxurl = "<?php echo admin_url( 'admin-ajax.php' ); ?>";
                var data = {
                  action: 'fl_slider_latestTopWork',
                  security: "<?php echo wp_create_nonce( 'fl_slider_latestTopWork-security' ); ?>",
                  category_id: prevCat
                };
                jQuery.post(ajaxurl, data, function(response) {
                  var json = jQuery.parseJSON(response);
                  $.each(json, function(key, item) {
                    $('#iframeContainer').children('iframe').attr('src', json[0]['vimeoURL']);
                    $('#workExpand').children('.inner').html('<h1>'+json[0]['post_title']+'</h1><h2>'+json[0]['date']+' | '+json[0]['clientName']+'</h2><p>'+json[0]['post_excerpt']+'</p><a href="'+json[0]['fullLink']+'">VIEW FULL CASE STUDY</a>');
                    $('.topSlider').css('background-image','url('+json[0]['featured_image_url']+')');
                  });

                }); // END Load previous cat in top area

                //
                // Load subsequent posts into slider
                //
                var prevCat = prevCat.replace("cat", "");

                ajaxurl = "<?php echo admin_url( 'admin-ajax.php' ); ?>";
                var data = {
                  action: 'fl_slider_latestSlider',
                  security: "<?php echo wp_create_nonce( 'fl_slider_latestSlider-security' ); ?>",
                  category_id: prevCat
                };
                jQuery.post(ajaxurl, data, function(response) {
                  var json = jQuery.parseJSON(response);
                  var data = json, post;

                  // Remove all existing category slides
                  $('#postSelector').data('flexslider').removeSlide(0);
                  var slider = $('#postSelector');
                  while (slider.data('flexslider').count > 0) slider.data('flexslider').removeSlide(0);

                  for( var i = 0; i < data.length; i++ ) {
                    post = data[i];
                    var html = '<li class="post-'+post['post_id']+'">'+post['featured_image']+'</li>';
                    $('#postSelector').data('flexslider').addSlide(html);
                  }

                  $('#postSelector li:first-child').addClass('active');

                }); // END Load subsequent posts into slider




              } else { 


                // At beginning of list, go to last category and load the sections


                // Get & set Category number & title
                
                var lastCat = $('.workCategories li:last-child').attr('id');
                var lastCatNum = lastCat.replace("cat", "");
                var lastCatName = $('.workCategories li:last-child').text();
                

                console.log('wha122t');


                console.log(lastCat+' '+lastCatName+' '+lastCatNum);

                // Remove, add new category name
                $('.categorySwitch').text('');
                $('.categorySwitch').text(lastCatName);

                  $( ".workCategories li" ).removeClass('active');
                  

                  //
                  // Load previous cat in top area
                  //
                  ajaxurl = "<?php echo admin_url( 'admin-ajax.php' ); ?>";
                  var data = {
                    action: 'fl_slider_latestTopWork',
                    security: "<?php echo wp_create_nonce( 'fl_slider_latestTopWork-security' ); ?>",
                    category_id: lastCatNum
                  };
                  jQuery.post(ajaxurl, data, function(response) {
                    var json = jQuery.parseJSON(response);
                    $.each(json, function(key, item) {
                      $('#iframeContainer').children('iframe').attr('src', json[0]['vimeoURL']);
                      $('#workExpand').children('.inner').html('<h1>'+json[0]['post_title']+'</h1><h2>'+json[0]['date']+' | '+json[0]['clientName']+'</h2><p>'+json[0]['post_excerpt']+'</p><a href="'+json[0]['fullLink']+'">VIEW FULL CASE STUDY</a>');
                      $('.topSlider').css('background-image','url('+json[0]['featured_image_url']+')');
                    });

                  }); // END Load previous cat in top area

                  //
                  // Load subsequent posts into slider
                  //

                  ajaxurl = "<?php echo admin_url( 'admin-ajax.php' ); ?>";
                  var data = {
                    action: 'fl_slider_latestSlider',
                    security: "<?php echo wp_create_nonce( 'fl_slider_latestSlider-security' ); ?>",
                    category_id: lastCatNum
                  };
                  jQuery.post(ajaxurl, data, function(response) {
                    var json = jQuery.parseJSON(response);
                    var data = json, post;

                    // Remove all existing category slides
                    $('#postSelector').data('flexslider').removeSlide(0);
                    var slider = $('#postSelector');
                    while (slider.data('flexslider').count > 0) slider.data('flexslider').removeSlide(0);

                    for( var i = 0; i < data.length; i++ ) {
                      post = data[i];
                      var html = '<li class="post-'+post['post_id']+'">'+post['featured_image']+'</li>';
                      $('#postSelector').data('flexslider').addSlide(html);
                    }

                    $('#postSelector li:first-child').addClass('active');
                    $('.workCategories').find('#' + lastCat).addClass('active');

                  }); // END Load subsequent posts into slider



              }; // prevCat undefined check

              
            } // end has class

          });




      });










      //
      // RIGHT Category arrow click
      //
  
      $('.catRight').click(function(e) {

          // Get current category by nav class & load previous category top and thumbnails
          $( ".workCategories li" ).each(function() {

            if ($(this).hasClass("active")) {

              var nextCat = $(this).next().attr('id');

              if(typeof nextCat !== "undefined"){

                // Get & set Category number & title
                var nextCatName = $(this).next().text();

                // Remove, add new category name
                $('.categorySwitch').text('');
                $('.categorySwitch').text(nextCatName);

                $( ".workCategories li" ).removeClass('active');

                //
                // Load previous cat in top area
                //
                ajaxurl = "<?php echo admin_url( 'admin-ajax.php' ); ?>";
                var data = {
                  action: 'fl_slider_latestTopWork',
                  security: "<?php echo wp_create_nonce( 'fl_slider_latestTopWork-security' ); ?>",
                  category_id: nextCat
                };
                jQuery.post(ajaxurl, data, function(response) {
                  var json = jQuery.parseJSON(response);
                  $.each(json, function(key, item) {
                    $('#iframeContainer').children('iframe').attr('src', json[0]['vimeoURL']);
                    $('#workExpand').children('.inner').html('<h1>'+json[0]['post_title']+'</h1><h2>'+json[0]['date']+' | '+json[0]['clientName']+'</h2><p>'+json[0]['post_excerpt']+'</p><a href="'+json[0]['fullLink']+'">VIEW FULL CASE STUDY</a>');
                    $('.topSlider').css('background-image','url('+json[0]['featured_image_url']+')');
                  });

                }); // END Load previous cat in top area

                //
                // Load subsequent posts into slider
                //
                var nextCat = nextCat.replace("cat", "");

                ajaxurl = "<?php echo admin_url( 'admin-ajax.php' ); ?>";
                var data = {
                  action: 'fl_slider_latestSlider',
                  security: "<?php echo wp_create_nonce( 'fl_slider_latestSlider-security' ); ?>",
                  category_id: nextCat
                };
                jQuery.post(ajaxurl, data, function(response) {
                  var json = jQuery.parseJSON(response);
                  var data = json, post;

                  // Remove all existing category slides
                  $('#postSelector').data('flexslider').removeSlide(0);
                  var slider = $('#postSelector');
                  while (slider.data('flexslider').count > 0) slider.data('flexslider').removeSlide(0);

                  for( var i = 0; i < data.length; i++ ) {
                    post = data[i];
                    var html = '<li class="post-'+post['post_id']+'">'+post['featured_image']+'</li>';
                    $('#postSelector').data('flexslider').addSlide(html);
                  }

                  $('#postSelector li:first-child').addClass('active');

                  $('.workCategories').find('#cat' + nextCat).addClass('active');

                }); // END Load subsequent posts into slider




              } else { 

                // Get & set Category number & title
                
                var firstCat = $('.workCategories li:first-child').attr('id');
                var firstCatNum = firstCat.replace("cat", "");
                var firstCatName = $('.workCategories li:first-child').text();


                console.log(firstCat+' '+firstCatName+' '+firstCatNum);

                // Remove, add new category name
                $('.categorySwitch').text('');
                $('.categorySwitch').text(firstCatName);

                  $( ".workCategories li" ).removeClass('active');
                  

                  //
                  // Load previous cat in top area
                  //
                  ajaxurl = "<?php echo admin_url( 'admin-ajax.php' ); ?>";
                  var data = {
                    action: 'fl_slider_latestTopWork',
                    security: "<?php echo wp_create_nonce( 'fl_slider_latestTopWork-security' ); ?>",
                    category_id: firstCatNum
                  };
                  jQuery.post(ajaxurl, data, function(response) {
                    var json = jQuery.parseJSON(response);
                    $.each(json, function(key, item) {
                      $('#iframeContainer').children('iframe').attr('src', json[0]['vimeoURL']);
                      $('#workExpand').children('.inner').html('<h1>'+json[0]['post_title']+'</h1><h2>'+json[0]['date']+' | '+json[0]['clientName']+'</h2><p>'+json[0]['post_excerpt']+'</p><a href="'+json[0]['fullLink']+'">VIEW FULL CASE STUDY</a>');
                      $('.topSlider').css('background-image','url('+json[0]['featured_image_url']+')');
                    });

                  }); // END Load previous cat in top area

                  //
                  // Load subsequent posts into slider
                  //

                  ajaxurl = "<?php echo admin_url( 'admin-ajax.php' ); ?>";
                  var data = {
                    action: 'fl_slider_latestSlider',
                    security: "<?php echo wp_create_nonce( 'fl_slider_latestSlider-security' ); ?>",
                    category_id: firstCatNum
                  };
                  jQuery.post(ajaxurl, data, function(response) {
                    var json = jQuery.parseJSON(response);
                    var data = json, post;

                    // Remove all existing category slides
                    $('#postSelector').data('flexslider').removeSlide(0);
                    var slider = $('#postSelector');
                    while (slider.data('flexslider').count > 0) slider.data('flexslider').removeSlide(0);

                    for( var i = 0; i < data.length; i++ ) {
                      post = data[i];
                      var html = '<li class="post-'+post['post_id']+'">'+post['featured_image']+'</li>';
                      $('#postSelector').data('flexslider').addSlide(html);
                    }

                    $('#postSelector li:first-child').addClass('active');
                    $('.workCategories').find('#' + firstCat).addClass('active');

                  }); // END Load subsequent posts into slider











              }; // nextCat undefined check

              
            } // end has class

          });




      });











    });











































