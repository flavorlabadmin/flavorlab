function updateViewportDimensions() {
  var w = window,
    d = document,
    e = d.documentElement,
    g = d.getElementsByTagName('body')[0],
    x = w.innerWidth || e.clientWidth || g.clientWidth,
    y = w.innerHeight || e.clientHeight || g.clientHeight;
  return {
    width: x,
    height: y
  };
}
// setting the viewport width
var viewport = updateViewportDimensions();

var waitForFinalEvent = (function() {
  var timers = {};
  return function(callback, ms, uniqueId) {
    if (!uniqueId) {
      uniqueId = "Don't call this twice without a uniqueId";
    }
    if (timers[uniqueId]) {
      clearTimeout(timers[uniqueId]);
    }
    timers[uniqueId] = setTimeout(callback, ms);
  };
})();

var timeToWaitForLast = 100;

var isMobile = {
  Android: function() {
    return navigator.userAgent.match(/Android/i);
  },
  BlackBerry: function() {
    return navigator.userAgent.match(/BlackBerry/i);
  },
  iOS: function() {
    return navigator.userAgent.match(/iPhone|iPad|iPod/i);
  },
  Opera: function() {
    return navigator.userAgent.match(/Opera Mini/i);
  },
  Windows: function() {
    return navigator.userAgent.match(/IEMobile/i) || navigator.userAgent.match(/WPDesktop/i);
  },
  any: function() {
    return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
  }
};









jQuery(document).ready(function($) {

  // Go to top button defaults
  var offset = 300,
    offset_opacity = 1200,
    scroll_top_duration = 700,
    $back_to_top = $('.cd-top');

  //hide or show the "back to top" link
  $(window).scroll(function() {
    ($(this).scrollTop() > offset) ? $back_to_top.addClass('cd-is-visible'): $back_to_top.removeClass('cd-is-visible cd-fade-out');
    if ($(this).scrollTop() > offset_opacity) {
      $back_to_top.addClass('cd-fade-out');
    }
  });

  //smooth scroll to top
  $back_to_top.on('click', function(event) {
    event.preventDefault();
    $('body,html').animate({
      scrollTop: 0,
    }, scroll_top_duration);
  });

  // Default category highlight
  $('li.direct-from-brands').addClass('active');

  // Initial Viewport Setting
  var eleH = $('.catSwitchContainer').height();
  $('.catSwitchContainer').css('top', -eleH - 100);

  // Page detect
  if (typeof is_home === "undefined") var is_home = $('body').hasClass('home');
  if (typeof is_single === "undefined") var is_single = $('body').hasClass('single');
  if (typeof is_score === "undefined") var is_score = $('body').hasClass('page-template-page-score');
  if (typeof is_sound === "undefined") var is_sound = $('body').hasClass('page-template-page-sound');
  if (typeof is_ptb === "undefined") var is_ptb = $('body').hasClass('page-template-page-producerstoolbox');


  // Store window width for actual resize checking
  var windowWidth = $(window).width();

  // On window resize setting
  $(window).resize(function() {

    if ($(window).width() != windowWidth) {
      windowWidth = $(window).width();
      if (is_home) {
        waitForFinalEvent(function() {

          if ($(window).width() < 1030) {
            var eleH = $('.catSwitchContainer').height();
            $('.catSwitchContainer').css('top', -eleH - 100);
          }

        }, 200, "homeResize");
      }


    } // end window width check (iOS scroll vs actual resize)

  });

  // Side Navigation Triggering
  $("#nav-icon").click(function(e) {
    $('#nav-icon').toggleClass('open');
    $('#container').toggleClass("open-sidebar");
    $("body, html").stop().animate({
      "scrollTop": "0px"
    }, 500);
    $('#content').toggleClass('open');
  });

  // Category Switcher
  $(".categorySwitch").click(function(e) {
    $('.catSwitchContainer').css('visibility', 'visible');
    var eleH = $('.catSwitchContainer').height();
    $('.catSwitchContainer').animate({
      'top': '0px'
    }, 300);
  });
  $(".close").click(function(e) {
    $('.catSwitchContainer').css('visibility', 'visible');
    var eleH = $('.catSwitchContainer').height();
    $('.catSwitchContainer').animate({
      'top': -eleH - 100
    }, 300);
  });



  //
  // Nav anchors animation + activation
  //
  $('nav.subNav ul li:first-child a').addClass('active');
  $(document).on("scroll", onScroll);

  $('nav.subNav ul a[href^="#"]').on('click', function(e) {
    e.preventDefault();
    $(document).off("scroll");

    $('a').each(function() {
      $(this).removeClass('active');
    });
    $(this).addClass('active');

    var target = this.hash,
      menu = target;
    $target = $(target);

    // If it's the work link, go to the top of the page, don't target the anchor
    if ($(this).attr('href') === '#work') {
      $('html, body').animate({
        scrollTop: 0
      }, 600, 'easeInOutQuart');
    } else {
      $('html, body').stop().animate({
        'scrollTop': $target.offset().top
      }, 600, 'easeInOutQuart', function() {
        window.location.hash = target;
        $(document).on("scroll", onScroll);
      });
    }

  });

  function onScroll(event) {
    setTimeout(function() {
      var scrollPos = $(document).scrollTop();
      $('nav.subNav ul a').each(function() {
        try {
          var currLink = $(this);
          var refElement = $(currLink.attr("href"));
          if (refElement.position().top - 30 <= scrollPos && refElement.position().top + refElement.height() > scrollPos) {
            $('nav.subNav ul a').removeClass("active");
            currLink.addClass("active");
          } else {
            currLink.removeClass("active");
          }
        } catch (e) {}
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
  // FL Top Slider
  //

  // Case study expand toggling
  $("#expand").click(function(e) {
    $(this).css('visibility', 'hidden');
    $('#workExpand').stop().slideToggle("slow");

    $('html, body').stop().animate({
      'scrollTop': $(this).offset().top - 30
    }, 600, 'easeInOutQuart', function() {
      $(document).on("scroll", onScroll);
    });

  });

  $("#workClose").click(function(e) {
    $('#workExpand').slideToggle("slow", function() {
      $('#expand').css('visibility', 'visible');
      $('html, body').animate({
        scrollTop: 0
      }, 300);
    });
  });
  
  
  // new version - case study viewed in place
 /* $("#workClose").click(function(e) {
		$('#workExpand').slideToggle("slow", function() {
		  $('#expand').css('visibility', 'visible');
		  $('html, body').animate({
			//scrollTop: 0
			scrollTop: $(".catSwitchContainer").offset().top}, 300);
		});
  });*/

  //
  // Category menu switching
  //
  $(".workCategories li").click(function(e) {

    $('.workCategories li').removeClass('active');
    $(this).addClass('active');

    // Close category box
    $('.catSwitchContainer').css('visibility', 'visible');
    var eleH = $('.catSwitchContainer').height();
    $('.catSwitchContainer').animate({
      'top': -eleH - 100
    }, 300);

    // Get category name from class
    var category_name = $(this).attr('class').split(' ')[0];

    flLoadCatAndThumbs(category_name, post_id, topSliderAction, topSliderSecurity, ajaxurl);

    url = window.location.href;
	//url = window.location.href + '#work';
    paramName = 'category';
    paramValue = category_name;
    var pattern = new RegExp('(' + paramName + '=).*?(&|$)');
    var newUrl = url.replace(pattern, '$1' + paramValue + '$2');
    var n = url.indexOf(paramName);
    if (n == -1) {
      newUrl = newUrl + (newUrl.indexOf('?') > 0 ? '&' : '?') + paramName + '=' + paramValue;
    }

    window.location.href = newUrl;

  }); // Work Categories

  //
  // Sidebar link clicking
  // -- needs to close the sidebar

  $("#sidebar ul li").on('click', function(e) {
    setTimeout(function() {
      $('#nav-icon').toggleClass('open');
      $('#container').toggleClass("open-sidebar");
      $('#content').toggleClass('open');
    }, 250);
  });


  //
  // Individual thumbnail clicks
  //
  $('#postSelector .slides').on('click', 'li', function() {

    // Get post ID
    var eleID = $(this).attr('class').split(' ').pop();
     eleID = eleID.replace("post-", "");

    // Load clicked thumbnail into main area
    var data = {
      action: 'fl_slider_thumbnailLoad',
      security: thumbNailSecurity,
      post_id: eleID
    };

    jQuery.post(ajaxurl, data, function(response) {
      var json = jQuery.parseJSON(response);
      //$('#iframeContainer').children('iframe').attr('src', json[0]['vimeoURL']);
      
      var ifsrc = json[0]['vimeoURL'];
      		var videourlend = ifsrc.toString().toLowerCase().split(".").pop();
			 	console.log(videourlend + ' click');
     	 	
     	 	// if no video, insert image
     	 	if( videourlend == "jpg" || videourlend == "jpeg" || videourlend == "png" ) {
       	 		
			 	//$('#iframeContainer').children('iframe').attr('src', 'http://dev.flavorlab.com/wp-content/themes/flavorlab/iframeimg.html'); 
				$('#iframeContainer').children('iframe').remove();
				$('#iframeContainer').children('img').remove(); 
			 	$('#iframeContainer').append('<img />'); 
			 	$('#iframeContainer').children('img').attr('src', ifsrc).css('width','100%'); 
			 
   			 } else {
   			 
   			 		if ($('#iframeContainer').children('iframe').length) {
   			 			$('#iframeContainer').children('iframe').attr('src', json[0]['vimeoURL']);	
   			 			$('iframe').attr('id','workiframe'); 
   			 			
   			 			}
   			 		else {
						$('#iframeContainer').children('img').remove(); 
   			 			$('#iframeContainer').append('<iframe></iframe>');
   			 			$('iframe').attr('id','workiframe'); 
						$('#iframeContainer').children('iframe').attr('src', json[0]['vimeoURL']);
			 		}
   			 }
      
      if(json[0]['show-view-case-study-link'] == 'false'){
      $('#expand').html('<h1 class="no-cs">' + json[0]['post_title'] + '</h1>'); //added 2017-08-01
        //$('#workExpand').children('.inner').html('<h1>' + json[0]['post_title'] + '</h1><h2>' + json[0]['date'] + ' | ' + json[0]['clientName'] + '</h2><p>' + json[0]['post_excerpt'] + '</p>'); // new formatting added below 2017-08-01
        $('#workExpand').children('.inner').html('<div class="workExpandLeft"><h1>' + json[0]['post_title'] + '</h1></div><div class="workExpandCenter"></div><div class="workExpandRight"><h2>' + json[0]['date'] + ' | ' + json[0]['clientName'] + '</h2><p>' + json[0]['post_excerpt'] + '</p></div>');
      } else {
      $('#expand').html('<h1>' + json[0]['post_title'] + '</h1>'); //added 2017-08-01
        //$('#workExpand').children('.inner').html('<h1>' + json[0]['post_title'] + '</h1><h2>' + json[0]['date'] + ' | ' + json[0]['clientName'] + '</h2><p>' + json[0]['post_excerpt'] + '</p> <a href="' + json[0]['fullLink'] + '">VIEW FULL CASE STUDY!</a>');
        $('#workExpand').children('.inner').html('<div class="workExpandLeft"><h1>' + json[0]['post_title'] + '</h1></div><div class="workExpandCenter"></div><div class="workExpandRight"><h2>' + json[0]['date'] + ' | ' + json[0]['clientName'] + '</h2><p>' + json[0]['post_excerpt'] + '</p><a href="' + json[0]['fullLink'] + '" class="view-fcs">VIEW FULL CASE STUDY</a></div>');
         //$('#workExpand').children('.inner').html('<div class="workExpandLeft"><h1>' + json[0]['post_title'] + '</h1></div><div class="workExpandCenter"></div><div class="workExpandRight"><h2>' + json[0]['date'] + ' | ' + json[0]['clientName'] + '</h2><p class="case-study-excerpt">' + json[0]['post_excerpt'] + '</p><button class="view-fcs">VIEW FULL CASE STUDY</button><div class="case-study-content" style="display:none;">' + json[0]['post_content'] + '</div></div>');
      }
      
       // show full case study in place
		 /* $(".view-fcs").click(function() {
			$(".case-study-excerpt").css("display", "none");
			$(".case-study-content").css("display", "block");
			$(this).css("display", "none");
		  });*/

      //Animate out the background and back in
      $(".sliderBG").stop().fadeOut(1000, function() {
        $(this).css('background-image', 'url(' + json[0]['featured_image_url'] + ')');
        $(this).delay(500).fadeIn(1500);
      });

    });

    // Toggle active thumbnail classes
    $('.slides li').removeClass('active');
    $(this).addClass('active');
    
  
	
    

  }); // Thumbnail click



  //
  // Left Category Click
  //
  $('.catLeft').click(function(e) {
    // Get current category by nav class & load previous category top and thumbnails
    $(".catSwitchInner li").each(function() {
      if ($(this).hasClass("active")) {
        var prevCat = $(this).prev().attr('id');
        if (typeof prevCat != "undefined") {
          $(".catSwitchInner li").removeClass('active');
          $('#' + prevCat).addClass('active');
          var category_name = $(this).prev().attr('class').split(' ')[0];
          // Remove hashtag if any and Set URL
          url = window.location.href.split('#')[0];
          paramName = 'category';
          paramValue = category_name;
          var pattern = new RegExp('(' + paramName + '=).*?(&|$)')
          var newUrl = url.replace(pattern, '$1' + paramValue + '$2');
          var n = url.indexOf(paramName);
          if (n == -1) {
            newUrl = newUrl + (newUrl.indexOf('?') > 0 ? '&' : '?') + paramName + '=' + paramValue
          }
          window.location.href = newUrl;
        }
      }
    }); //cat .each inner
  });



  //
  // Right Category Click
  //
  $('.catRight').click(function(e) {
    // Get current category by nav class & load next category top and thumbnails
    $(".catSwitchInner li").each(function() {
      if ($(this).hasClass("active")) {
        var nextCat = $(this).next().attr('id');
        if (typeof nextCat != "undefined") {
          var category_name = $(this).next().attr('class').split(' ')[0];
          // Remove hashtag if any and Set URL
          url = window.location.href.split('#')[0];
          paramName = 'category';
          paramValue = category_name;
          var pattern = new RegExp('(' + paramName + '=).*?(&|$)')
          var newUrl = url.replace(pattern, '$1' + paramValue + '$2');
          var n = url.indexOf(paramName);
          if (n == -1) {
            newUrl = newUrl + (newUrl.indexOf('?') > 0 ? '&' : '?') + paramName + '=' + paramValue
          }
          window.location.href = newUrl;
        }
      }
    }); //cat .each inner
  });


  //
  // FL Top Slider category loading + thumbnails
  //

  //
  // URL Parameters
  //
  var category_id, post_id;


  //Init
  flLoadCatAndThumbs(category_name, post_id, topSliderAction, topSliderSecurity, ajaxurl);

  function flLoadCatAndThumbs(category_name, post_id, topSliderAction, topSliderSecurity, ajaxurl) {

    try {

      $('.workCategories').children().removeClass('active');
      $('.workCategories').children('.' + category_name).addClass('active');

      var catNum = $('.workCategories').children('.' + category_name).attr('id').replace("cat", "");

      var data = {
        action: topSliderAction,
        security: topSliderSecurity,
        category_id: catNum,
        post_id: post_id
      };
      jQuery.post(ajaxurl, data, function(response) {

        var json = jQuery.parseJSON(response);
        // Any errors with getting the category
        if (json[0]['error']) {
          flWorkItemError();
        } else {

          // Get first post in hero area of category
     	 //$('#iframeContainer').children('iframe').attr('src', json[0]['vimeoURL']);
      
      		var ifsrc = json[0]['vimeoURL'];
      		var videourlend = ifsrc.toString().toLowerCase().split(".").pop();
			 	console.log(videourlend + ' first');
     	 	
     	 	// if no video, insert image
     	 	if( videourlend == "jpg" || videourlend == "jpeg" || videourlend == "png" ) {
       	 		
			 	//$('#iframeContainer').children('iframe').attr('src', 'http://dev.flavorlab.com/wp-content/themes/flavorlab/iframeimg.html'); 
				$('#iframeContainer').children('iframe').remove();
				$('#iframeContainer').children('img').remove(); 
			 	$('#iframeContainer').append('<img />'); 
			 	$('#iframeContainer').children('img').attr('src', ifsrc).css('width','100%'); 
			 
   			 } else {
   			 
   			 		if ($('#iframeContainer').children('iframe').length) {
   			 			$('iframe').attr('id','workiframe'); 
   			 			$('#iframeContainer').children('iframe').attr('src', json[0]['vimeoURL']);	}
   			 		else {
						$('#iframeContainer').children('img').remove(); 
   			 			$('#iframeContainer').append('<iframe></iframe>');
   			 			$('iframe').attr('id','workiframe'); 
						$('#iframeContainer').children('iframe').attr('src', json[0]['vimeoURL']);
			 		}
   			 }
          
         // $('#workExpand').children('.inner').html('<h1>' + json[0]['post_title'] + '</h1><h2>' + json[0]['date'] + ' | ' + json[0]['clientName'] + '</h2><p>' + json[0]['post_excerpt'] + '</p><a href="' + json[0]['fullLink'] + '">VIEW FULL CASE STUDY</a>');
         //$('#workExpand').children('.inner').html('<div class="workExpandLeft"><h1>' + json[0]['post_title'] + '</h1></div><div class="workExpandCenter"></div><div class="workExpandRight"><h2>' + json[0]['date'] + ' | ' + json[0]['clientName'] + '</h2><p>' + json[0]['post_excerpt'] + '</p><a href="' + json[0]['fullLink'] + '" class="view-fcs">VIEW FULL CASE STUDY</a></div>');
         
        //added 2017-06-29 to prevent View Case Study button loading for projects without case studies
          if(json[0]['show-view-case-study-link'] == 'false'){
           $('#expand').html('<h1 class="no-cs">' + json[0]['post_title'] + '</h1>'); //added 2017-08-01 
        //$('#workExpand').children('.inner').html('<h1>' + json[0]['post_title'] + '</h1><h2>' + json[0]['date'] + ' | ' + json[0]['clientName'] + '</h2><p>' + json[0]['post_excerpt'] + '</p>'); // new formatting added below 2017-08-01
        $('#workExpand').children('.inner').html('<div class="workExpandLeft"><h1>' + json[0]['post_title'] + '</h1></div><div class="workExpandCenter"></div><div class="workExpandRight"><h2>' + json[0]['date'] + ' | ' + json[0]['clientName'] + '</h2><p>' + json[0]['post_excerpt'] + '</p></div>');
		  } else {
		   $('#expand').html('<h1>' + json[0]['post_title'] + '</h1>'); //added 2017-08-01 
			//$('#workExpand').children('.inner').html('<h1>' + json[0]['post_title'] + '</h1><h2>' + json[0]['date'] + ' | ' + json[0]['clientName'] + '</h2><p>' + json[0]['post_excerpt'] + '</p> <a href="' + json[0]['fullLink'] + '">VIEW FULL CASE STUDY!</a>');
			$('#workExpand').children('.inner').html('<div class="workExpandLeft"><h1>' + json[0]['post_title'] + '</h1></div><div class="workExpandCenter"></div><div class="workExpandRight"><h2>' + json[0]['date'] + ' | ' + json[0]['clientName'] + '</h2><p>' + json[0]['post_excerpt'] + '</p><a href="' + json[0]['fullLink'] + '" class="view-fcs">VIEW FULL CASE STUDY</a></div>');
			//$('#workExpand').children('.inner').html('<div class="workExpandLeft"><h1>' + json[0]['post_title'] + '</h1></div><div class="workExpandCenter"></div><div class="workExpandRight"><h2>' + json[0]['date'] + ' | ' + json[0]['clientName'] + '</h2><p class="case-study-excerpt">' + json[0]['post_excerpt'] + '</p><button class="view-fcs">VIEW FULL CASE STUDY</button><div class="case-study-content" style="display:none;">' + json[0]['post_content'] + '</div></div>');
		  }
      
        // show full case study in place
		  /*$(".view-fcs").click(function() {
			$(".case-study-excerpt").css("display", "none");
			$(".case-study-content").css("display", "block");
			$(this).css("display", "none");
		  });*/

          $('.sliderBG').css('background-image', 'url(' + json[0]['featured_image_url'] + ')');
          
          
    		

          // Remove all existing slides
          var slider = $('#postSelector');
          while (slider.data('flexslider').count > 0)
            slider.data('flexslider').removeSlide(0);

          $.each(json, function(i, post) {
            // Thumbnails for current category
            var thumbHtml = '<li class="cat-' + post.cat_id + ' post-' + post.post_id + '"><img src="' + post.sliderThumbnailURL + '" /></li>';
            $('#postSelector').data('flexslider').addSlide(thumbHtml);
          });

          var cleanCatName = category_name.replace(/-/g, ' ');
          cleanCatName = cleanCatName.replace('score ', '');
          cleanCatName = cleanCatName.replace('sound ', '');
          cleanCatName = cleanCatName.replace('producerstoolbox ', '');
          $('.categorySwitch').text('');
          $('.categorySwitch').text(cleanCatName);
        }
      });
    } catch (err) {
      console.log('Cannot fetch category / thumbs for highlighted category. Error: ' + err);
    }
  }

  function flWorkItemError() {
    // Show error message in iframe container elements
    $('#expand').html('');
    $('#iframeContainer').css('background', 'black url(not_found.png) 50% 50% no-repeat');
    $('#iframeContainer').children('iframe').attr('src', '');
    $('#workExpand').children('.inner').html('<h1>NOT FOUND</h1><h2>We cannot find the work item or category you are trying to access</h2><p></p>');
    $('.topSlider').css('background-image', 'url()');
  }






  //
  // Team member slider
  //

  $('#teamMembers').flexslider({
    animation: "slide",
    animationSpeed: 400,
    slideshowSpeed: 3000,
    pauseOnHover: true,
    initDelay: 0,
    itemWidth: 240,
    animationLoop: true,
    touch: true
  });

  // Swap phone icon urls for mobile only as required by flavorlab
  if (!isMobile.any()) {
    //alert('not mobile');
    $('.headerIcons').find('.fa-phone-square').parent('a').attr('href', '#contact');
  }
  

  if (isMobile.any()) {

    // Show "swipe to see more" for mobile only
    $('.swipeMore').css('display', 'block');

    $("#teamMembers .slides li").on('mousedown', function(e) {
      e.stopPropagation();
      $("#teamMembers .slides li .expand,#teamMembers .slides li .expClose").removeClass('active');
      $(this).children('.expand').addClass('active');
      $(this).children('.expClose').addClass('active');
    });

    $("#teamMembers li .expClose").on('mousedown', function(e) {
      e.stopPropagation();
      $("#teamMembers .slides li .expand,#teamMembers .slides li .expClose").removeClass('active');
    });
  } else {
    $("#teamMembers .slides li").on('click', function(e) {
      e.stopPropagation();
      $("#teamMembers .slides li .expand,#teamMembers .slides li .expClose").removeClass('active');
      $(this).children('.expand').addClass('active');
      $(this).children('.expClose').addClass('active');
    });

    $("#teamMembers li .expClose").on('click', function(e) {
      e.stopPropagation();
      $("#teamMembers .slides li .expand,#teamMembers .slides li .expClose").removeClass('active');
    });
  }
  
  // Testimonials slider

  $('#testimonialSlides').flexslider({
    animation: "fade",
    animationSpeed: 400,
    slideshowSpeed: 20000,
    pauseOnHover: true,
    initDelay: 0,
    itemWidth: 960,
    animationLoop: true,
    touch: true
  });

}); /* end of as page load scripts */

// Get URL Parameters
var getUrlParameter = function getUrlParameter(sParam) {
  var sPageURL = decodeURIComponent(window.location.search.substring(1)),
    sURLVariables = sPageURL.split('&'),
    sParameterName,
    i;
  for (i = 0; i < sURLVariables.length; i++) {
    sParameterName = sURLVariables[i].split('=');
    if (sParameterName[0] === sParam) {
      return sParameterName[1] === undefined ? true : sParameterName[1];
    }
  }
};

// Set / replace URL parameters
function replaceUrlParam(url, paramName, paramValue) {
  var pattern = new RegExp('\\b(' + paramName + '=).*?(&|$)')
  if (url.search(pattern) >= 0) {
    return url.replace(pattern, '$1' + paramValue + '$2');
  }
  return url + (url.indexOf('?') > 0 ? '&' : '?') + paramName + '=' + paramValue
}

/*
 * jQuery Easing v1.3.2 - http://gsgd.co.uk/sandbox/jquery/easing/
 * Open source under the BSD License.
 * Copyright Â© 2008 George McGinley Smith
 * All rights reserved.
 * https://raw.github.com/gdsmith/jquery-easing/master/LICENSE
 */
(function(h) {
  h.easing.jswing = h.easing.swing;
  h.extend(h.easing, {
    def: "easeOutQuad",
    swing: function(e, a, c, b, d) {
      return h.easing[h.easing.def](e, a, c, b, d)
    },
    easeInQuad: function(e, a, c, b, d) {
      return b * (a /= d) * a + c
    },
    easeOutQuad: function(e, a, c, b, d) {
      return -b * (a /= d) * (a - 2) + c
    },
    easeInOutQuad: function(e, a, c, b, d) {
      return 1 > (a /= d / 2) ? b / 2 * a * a + c : -b / 2 * (--a * (a - 2) - 1) + c
    },
    easeInCubic: function(e, a, c, b, d) {
      return b * (a /= d) * a * a + c
    },
    easeOutCubic: function(e, a, c, b, d) {
      return b * ((a = a / d - 1) * a * a + 1) + c
    },
    easeInOutCubic: function(e, a, c, b, d) {
      return 1 >
        (a /= d / 2) ? b / 2 * a * a * a + c : b / 2 * ((a -= 2) * a * a + 2) + c
    },
    easeInQuart: function(e, a, c, b, d) {
      return b * (a /= d) * a * a * a + c
    },
    easeOutQuart: function(e, a, c, b, d) {
      return -b * ((a = a / d - 1) * a * a * a - 1) + c
    },
    easeInOutQuart: function(e, a, c, b, d) {
      return 1 > (a /= d / 2) ? b / 2 * a * a * a * a + c : -b / 2 * ((a -= 2) * a * a * a - 2) + c
    },
    easeInQuint: function(e, a, c, b, d) {
      return b * (a /= d) * a * a * a * a + c
    },
    easeOutQuint: function(e, a, c, b, d) {
      return b * ((a = a / d - 1) * a * a * a * a + 1) + c
    },
    easeInOutQuint: function(e, a, c, b, d) {
      return 1 > (a /= d / 2) ? b / 2 * a * a * a * a * a + c : b / 2 * ((a -= 2) * a * a * a * a + 2) + c
    },
    easeInSine: function(e, a,
      c, b, d) {
      return -b * Math.cos(a / d * (Math.PI / 2)) + b + c
    },
    easeOutSine: function(e, a, c, b, d) {
      return b * Math.sin(a / d * (Math.PI / 2)) + c
    },
    easeInOutSine: function(e, a, c, b, d) {
      return -b / 2 * (Math.cos(Math.PI * a / d) - 1) + c
    },
    easeInExpo: function(e, a, c, b, d) {
      return 0 == a ? c : b * Math.pow(2, 10 * (a / d - 1)) + c
    },
    easeOutExpo: function(e, a, c, b, d) {
      return a == d ? c + b : b * (-Math.pow(2, -10 * a / d) + 1) + c
    },
    easeInOutExpo: function(e, a, c, b, d) {
      return 0 == a ? c : a == d ? c + b : 1 > (a /= d / 2) ? b / 2 * Math.pow(2, 10 * (a - 1)) + c : b / 2 * (-Math.pow(2, -10 * --a) + 2) + c
    },
    easeInCirc: function(e, a, c, b, d) {
      return -b *
        (Math.sqrt(1 - (a /= d) * a) - 1) + c
    },
    easeOutCirc: function(e, a, c, b, d) {
      return b * Math.sqrt(1 - (a = a / d - 1) * a) + c
    },
    easeInOutCirc: function(e, a, c, b, d) {
      return 1 > (a /= d / 2) ? -b / 2 * (Math.sqrt(1 - a * a) - 1) + c : b / 2 * (Math.sqrt(1 - (a -= 2) * a) + 1) + c
    },
    easeInElastic: function(e, a, c, b, d) {
      e = 1.70158;
      var f = 0,
        g = b;
      if (0 == a) return c;
      if (1 == (a /= d)) return c + b;
      f || (f = .3 * d);
      g < Math.abs(b) ? (g = b, e = f / 4) : e = f / (2 * Math.PI) * Math.asin(b / g);
      return -(g * Math.pow(2, 10 * --a) * Math.sin(2 * (a * d - e) * Math.PI / f)) + c
    },
    easeOutElastic: function(e, a, c, b, d) {
      e = 1.70158;
      var f = 0,
        g = b;
      if (0 ==
        a) return c;
      if (1 == (a /= d)) return c + b;
      f || (f = .3 * d);
      g < Math.abs(b) ? (g = b, e = f / 4) : e = f / (2 * Math.PI) * Math.asin(b / g);
      return g * Math.pow(2, -10 * a) * Math.sin(2 * (a * d - e) * Math.PI / f) + b + c
    },
    easeInOutElastic: function(e, a, c, b, d) {
      e = 1.70158;
      var f = 0,
        g = b;
      if (0 == a) return c;
      if (2 == (a /= d / 2)) return c + b;
      f || (f = .3 * d * 1.5);
      g < Math.abs(b) ? (g = b, e = f / 4) : e = f / (2 * Math.PI) * Math.asin(b / g);
      return 1 > a ? -.5 * g * Math.pow(2, 10 * --a) * Math.sin(2 * (a * d - e) * Math.PI / f) + c : g * Math.pow(2, -10 * --a) * Math.sin(2 * (a * d - e) * Math.PI / f) * .5 + b + c
    },
    easeInBack: function(e, a, c, b, d, f) {
      void 0 ==
        f && (f = 1.70158);
      return b * (a /= d) * a * ((f + 1) * a - f) + c
    },
    easeOutBack: function(e, a, c, b, d, f) {
      void 0 == f && (f = 1.70158);
      return b * ((a = a / d - 1) * a * ((f + 1) * a + f) + 1) + c
    },
    easeInOutBack: function(e, a, c, b, d, f) {
      void 0 == f && (f = 1.70158);
      return 1 > (a /= d / 2) ? b / 2 * a * a * (((f *= 1.525) + 1) * a - f) + c : b / 2 * ((a -= 2) * a * (((f *= 1.525) + 1) * a + f) + 2) + c
    },
    easeInBounce: function(e, a, c, b, d) {
      return b - h.easing.easeOutBounce(e, d - a, 0, b, d) + c
    },
    easeOutBounce: function(e, a, c, b, d) {
      return (a /= d) < 1 / 2.75 ? 7.5625 * b * a * a + c : a < 2 / 2.75 ? b * (7.5625 * (a -= 1.5 / 2.75) * a + .75) + c : a < 2.5 / 2.75 ? b * (7.5625 *
        (a -= 2.25 / 2.75) * a + .9375) + c : b * (7.5625 * (a -= 2.625 / 2.75) * a + .984375) + c
    },
    easeInOutBounce: function(e, a, c, b, d) {
      return a < d / 2 ? .5 * h.easing.easeInBounce(e, 2 * a, 0, b, d) + c : .5 * h.easing.easeOutBounce(e, 2 * a - d, 0, b, d) + .5 * b + c
    }
  })
})(jQuery);
