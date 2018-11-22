(function($) {

  $(".workCategories li").click(function(e) {

    alert('click');
    e.preventDefault();

    page = 15;

    $.ajax({
      url: FLWorkSlider.ajaxurl,
      type: 'post',
      data: {
        action: 'FL_WorkSlider',
        query_vars: "FLWorkSlider.query_vars",
        page: page
      },
      beforeSend: function() {
        $('#workExpand').append( '<div class="page-content" id="loader">Loading New Posts...</div>' );
      },
      success: function( html ) {
        console.log('Post HTML: '+html);
      }
    });

  });


})(jQuery);