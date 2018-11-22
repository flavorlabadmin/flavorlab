<?php
/*
Author: Eddie Machado
URL: http://themble.com/bones/

This is where you can drop your custom functions or
just edit things like thumbnail sizes, header images,
sidebars, comments, etc.
*/

// LOAD BONES CORE (if you remove this, the theme will break)
require_once( 'library/bones.php' );

// CUSTOMIZE THE WORDPRESS ADMIN (off by default)
// require_once( 'library/admin.php' );

/*********************
LAUNCH BONES
Let's get everything up and running.
*********************/

function bones_ahoy() {

  //Allow editor style.
  //add_editor_style( get_stylesheet_directory_uri() . '/library/css/editor-style.css' );

  // let's get language support going, if you need it
  load_theme_textdomain( 'bonestheme', get_template_directory() . '/library/translation' );

  // USE THIS TEMPLATE TO CREATE CUSTOM POST TYPES EASILY
  require_once( 'library/custom-post-type.php' );

  // launching operation cleanup
  add_action( 'init', 'bones_head_cleanup' );
  // A better title
  add_filter( 'wp_title', 'rw_title', 10, 3 );
  // remove WP version from RSS
  add_filter( 'the_generator', 'bones_rss_version' );
  // remove pesky injected css for recent comments widget
  add_filter( 'wp_head', 'bones_remove_wp_widget_recent_comments_style', 1 );
  // clean up comment styles in the head
  add_action( 'wp_head', 'bones_remove_recent_comments_style', 1 );
  // clean up gallery output in wp
  add_filter( 'gallery_style', 'bones_gallery_style' );

  // enqueue base scripts and styles
  add_action( 'wp_enqueue_scripts', 'bones_scripts_and_styles', 999 );
  // ie conditional wrapper

  // launching this stuff after theme setup
  bones_theme_support();

  // adding sidebars to Wordpress (these are created in functions.php)
  add_action( 'widgets_init', 'bones_register_sidebars' );

  // cleaning up random code around images
  add_filter( 'the_content', 'bones_filter_ptags_on_images' );
  // cleaning up excerpt
  add_filter( 'excerpt_more', 'bones_excerpt_more' );

} /* end bones ahoy */

// let's get this party started
add_action( 'after_setup_theme', 'bones_ahoy' );

































/*****
Flavorlab admin panel
*****/

/**
* Step 1: Create link to the menu page.
*/
add_action('admin_menu', 'fl_create_menu');
function fl_create_menu() {

  //create new top-level menu
  add_menu_page(__('Theme Settings', 'flsettings'), __('Flavorlab Settings', 'flsettings'), 'administrator', 'flsettings-theme-settings', 'fl_settings_page', 'dashicons-dashboard');
}

/**
* Step 2: Create settings fields.
*/
add_action( 'admin_init', 'register_flsettings' );
function register_flsettings() {
  register_setting( 'fl-settings-general', 'fl_analytics_code' );
  register_setting( 'fl-settings-general', 'FLHomepageDefaultWorkCat' );
  register_setting( 'fl-settings-general', 'FLScoreDefaultWorkCat' );
  register_setting( 'fl-settings-general', 'FLSoundDefaultWorkCat' );
  register_setting( 'fl-settings-general', 'FLPTBDefaultWorkCat' );

  register_setting( 'fl-settings-general', 'fl_homepage_socialmedia' );
  register_setting( 'fl-settings-general', 'fl_score_socialmedia' );
  register_setting( 'fl-settings-general', 'fl_sound_socialmedia' );
  register_setting( 'fl-settings-general', 'fl_ptb_socialmedia' );

}

/**
* Step 3: Create the markup for the options page
*/
function fl_settings_page() {

?>

<div class="wrap">
<h2><?php _e('FlavorLab Settings', 'flsettings'); ?></h2>

<form method="post" action="options.php">

  <?php if(isset( $_GET['settings-updated'])) { ?>
  <div class="updated">
    <p><?php _e('Sweet man! Settings updated successfully.', $textdomain); ?></p>
  </div>
  <?php } ?>

    <table class="form-table">

    <tr valign="top">
      <th scope="row"><?php _e('Google Analytics Code', 'flsettings'); ?></th>
      <td>
        <textarea rows="4" cols="50" name="fl_analytics_code"><?php echo get_option('fl_analytics_code'); ?></textarea>
        <p class="description"><?php _e('The Flavorlab google analytics tracking code.', 'flsettings'); ?></p>
      </td>
    </tr>

    <tr>
      <th scope="row" colspan="2">
        <h3>Default property work categories</h3>
        <p class="description">The "slug" names for the default property work categories, i.e. 'direct-from-brands' as shown in the categories page in wp-admin.</p>
      </th>
    </tr>

    <tr valign="top">
      <th scope="row"><?php _e('Flavorlab Homepage', 'flsettings'); ?></th>
      <td>
        <input name="FLHomepageDefaultWorkCat" value="<?php echo get_option('FLHomepageDefaultWorkCat'); ?>"></input>
      </td>
    </tr>
    <tr valign="top">
      <th scope="row"><?php _e('Score Homepage', 'flsettings'); ?></th>
      <td>
        <input name="FLScoreDefaultWorkCat" value="<?php echo get_option('FLScoreDefaultWorkCat'); ?>"></input>
      </td>
    </tr>
    <tr valign="top">
      <th scope="row"><?php _e('Sound Homepage', 'flsettings'); ?></th>
      <td>
        <input name="FLSoundDefaultWorkCat" value="<?php echo get_option('FLSoundDefaultWorkCat'); ?>"></input>
      </td>
    </tr>
    <tr valign="top">
      <th scope="row"><?php _e('Toolbox Homepage', 'flsettings'); ?></th>
      <td>
        <input name="FLPTBDefaultWorkCat" value="<?php echo get_option('FLPTBDefaultWorkCat'); ?>"></input>
      </td>
    </tr>

    <tr>
      <th scope="row" colspan="2">
        <h3>Header logos and social media icons</h3>
        <p class="description">These text boxes have the direct HTML for use in the top left part of the header area to control the different social media properties for each FlavorLab property.</p>
      </th>
    </tr>

    <tr valign="top">
      <th scope="row"><?php _e('Flavorlab Homepage', 'flsettings'); ?></th>
      <td>
        <textarea rows="10" cols="50" name="fl_homepage_socialmedia"><?php echo get_option('fl_homepage_socialmedia'); ?></textarea>
        <p class="description"><?php _e('Basic HTML for Top logo and social media icons', 'flsettings'); ?></p>
      </td>
    </tr>

    <tr valign="top">
      <th scope="row"><?php _e('Flavorlab Score', 'flsettings'); ?></th>
      <td>
        <textarea rows="10" cols="50" name="fl_score_socialmedia"><?php echo get_option('fl_score_socialmedia'); ?></textarea>
        <p class="description"><?php _e('Basic HTML for Top logo and social media icons', 'flsettings'); ?></p>
      </td>
    </tr>

    <tr valign="top">
      <th scope="row"><?php _e('Flavorlab Sound', 'flsettings'); ?></th>
      <td>
        <textarea rows="10" cols="50" name="fl_sound_socialmedia"><?php echo get_option('fl_sound_socialmedia'); ?></textarea>
        <p class="description"><?php _e('Basic HTML for Top logo and social media icons', 'flsettings'); ?></p>
      </td>
    </tr>

    <tr valign="top">
      <th scope="row"><?php _e('Flavorlab Producer\'s Toolbox', 'flsettings'); ?></th>
      <td>
        <textarea rows="10" cols="50" name="fl_ptb_socialmedia"><?php echo get_option('fl_ptb_socialmedia'); ?></textarea>
        <p class="description"><?php _e('Basic HTML for Top logo and social media icons', 'flsettings'); ?></p>
      </td>
    </tr>









    <?php // Put all setting fields into settings_field and fire off the admin options template ?>
    <?php settings_fields( 'fl-settings-general' ); ?>
    <?php do_settings_sections( 'fl-settings-general' ); ?>
    </table>

    <?php submit_button(); ?>
</form>
</div>
<?php }


































/************************
Navigation menu Dropdown
************************/
class Walker_Nav_Menu_Dropdown extends Walker_Nav_Menu {

    function start_lvl(&$output, $depth) {    }

    function end_lvl(&$output, $depth) {    }

    function start_el(&$output, $item, $depth, $args) {
        // Here is where we create each option.
        $item_output = '';

        // add spacing to the title based on the depth
        $item->title = str_repeat("&amp;nbsp;", $depth * 4) . $item->title;

        // Get the attributes.. Though we likely don't need them for this...
        $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

        // Add the html
        $item_output .= '<li><a'. $attributes .'>';
        $item_output .= apply_filters( 'the_title_attribute', $item->title );

        // Add this new item to the output string.
        $output .= $item_output;

    }

    function end_el(&$output, $item, $depth) {
        // Close the item.
        $output .= "</a></li>\n";

    }

}

add_action('wp_footer', 'dropdown_menu_scripts');
function dropdown_menu_scripts() {
    ?>
        <script>
          jQuery(document).ready(function ($) {
            $("#drop-nav").change( function() {
                    document.location.href =  $(this).val();
            });
          });
        </script>
    <?php
}


/************* OEMBED SIZE OPTIONS *************/

if ( ! isset( $content_width ) ) {
	$content_width = 960;
}

/************* THUMBNAIL SIZE OPTIONS *************/

// Thumbnail sizes
add_image_size( 'bones-thumb-600', 600, 150, true );
add_image_size( 'bones-thumb-300', 300, 100, true );
add_image_size( 'flavorlab-320320', 320, 320, true );
add_image_size( 'flavorlab-460', 460, 220, array( 'center', 'top' ));
add_image_size( 'flavorlab-960', 960, 300, true );
/*
to add more sizes, simply copy a line from above
and change the dimensions & name. As long as you
upload a "featured image" as large as the biggest
set width or height, all the other sizes will be
auto-cropped.

To call a different size, simply change the text
inside the thumbnail function.

For example, to call the 300 x 100 sized image,
we would use the function:
<?php the_post_thumbnail( 'bones-thumb-300' ); ?>
for the 600 x 150 image:
<?php the_post_thumbnail( 'bones-thumb-600' ); ?>

You can change the names and dimensions to whatever
you like. Enjoy!
*/

add_filter( 'image_size_names_choose', 'bones_custom_image_sizes' );

function bones_custom_image_sizes( $sizes ) {
    return array_merge( $sizes, array(
        'bones-thumb-600' => __('600px by 150px'),
        'bones-thumb-300' => __('300px by 100px'),
        'flavorlab-320320' => __('320px by 320px'),
        'flavorlab-460' => __('460px by 220px'),
        'flavorlab-960' => __('960px by 300px'),
    ) );
}

/*
The function above adds the ability to use the dropdown menu to select
the new images sizes you have just created from within the media manager
when you add media to your content blocks. If you add more image sizes,
duplicate one of the lines in the array and name it according to your
new image size.
*/

/************* THEME CUSTOMIZE *********************/

/*
  A good tutorial for creating your own Sections, Controls and Settings:
  http://code.tutsplus.com/series/a-guide-to-the-wordpress-theme-customizer--wp-33722

  Good articles on modifying the default options:
  http://natko.com/changing-default-wordpress-theme-customization-api-sections/
  http://code.tutsplus.com/tutorials/digging-into-the-theme-customizer-components--wp-27162

  To do:
  - Create a js for the postmessage transport method
  - Create some sanitize functions to sanitize inputs
  - Create some boilerplate Sections, Controls and Settings
*/

function bones_theme_customizer($wp_customize) {
  // $wp_customize calls go here.
  //
  // Uncomment the below lines to remove the default customize sections

  // $wp_customize->remove_section('title_tagline');
  // $wp_customize->remove_section('colors');
  // $wp_customize->remove_section('background_image');
  // $wp_customize->remove_section('static_front_page');
  // $wp_customize->remove_section('nav');

  // Uncomment the below lines to remove the default controls
  // $wp_customize->remove_control('blogdescription');

  // Uncomment the following to change the default section titles
  // $wp_customize->get_section('colors')->title = __( 'Theme Colors' );
  // $wp_customize->get_section('background_image')->title = __( 'Images' );
}

add_action( 'customize_register', 'bones_theme_customizer' );

/************* ACTIVE SIDEBARS ********************/

// Sidebars & Widgetizes Areas
function bones_register_sidebars() {
	register_sidebar(array(
		'id' => 'sidebar1',
		'name' => __( 'Sidebar 1', 'bonestheme' ),
		'description' => __( 'The first (primary) sidebar.', 'bonestheme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

	/*
	to add more sidebars or widgetized areas, just copy
	and edit the above sidebar code. In order to call
	your new sidebar just use the following code:

	Just change the name to whatever your new
	sidebar's id is, for example:

	register_sidebar(array(
		'id' => 'sidebar2',
		'name' => __( 'Sidebar 2', 'bonestheme' ),
		'description' => __( 'The second (secondary) sidebar.', 'bonestheme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

	To call the sidebar in your template, you can just copy
	the sidebar.php file and rename it to your sidebar's name.
	So using the above example, it would be:
	sidebar-sidebar2.php

	*/
} // don't remove this bracket!


/************* COMMENT LAYOUT *********************/

// Comment Layout
function bones_comments( $comment, $args, $depth ) {
   $GLOBALS['comment'] = $comment; ?>
  <div id="comment-<?php comment_ID(); ?>" <?php comment_class('cf'); ?>>
    <article  class="cf">
      <header class="comment-author vcard">
        <?php
        /*
          this is the new responsive optimized comment image. It used the new HTML5 data-attribute to display comment gravatars on larger screens only. What this means is that on larger posts, mobile sites don't have a ton of requests for comment images. This makes load time incredibly fast! If you'd like to change it back, just replace it with the regular wordpress gravatar call:
          echo get_avatar($comment,$size='32',$default='<path_to_url>' );
        */
        ?>
        <?php // custom gravatar call ?>
        <?php
          // create variable
          $bgauthemail = get_comment_author_email();
        ?>
        <img data-gravatar="http://www.gravatar.com/avatar/<?php echo md5( $bgauthemail ); ?>?s=40" class="load-gravatar avatar avatar-48 photo" height="40" width="40" src="<?php echo get_template_directory_uri(); ?>/library/images/nothing.gif" />
        <?php // end custom gravatar call ?>
        <?php printf(__( '<cite class="fn">%1$s</cite> %2$s', 'bonestheme' ), get_comment_author_link(), edit_comment_link(__( '(Edit)', 'bonestheme' ),'  ','') ) ?>
        <time datetime="<?php echo comment_time('Y-m-j'); ?>"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php comment_time(__( 'F jS, Y', 'bonestheme' )); ?> </a></time>

      </header>
      <?php if ($comment->comment_approved == '0') : ?>
        <div class="alert alert-info">
          <p><?php _e( 'Your comment is awaiting moderation.', 'bonestheme' ) ?></p>
        </div>
      <?php endif; ?>
      <section class="comment_content cf">
        <?php comment_text() ?>
      </section>
      <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
    </article>
  <?php // </li> is added by WordPress automatically ?>
<?php
} // don't remove this bracket!




/*
This is a modification of a function found in the
twentythirteen theme where we can declare some
external fonts. If you're using Google Fonts, you
can replace these fonts, change it in your scss files
and be up and running in seconds.
*/
function bones_fonts() {
  wp_enqueue_style('googleFonts', 'http://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic');
}

add_action('wp_enqueue_scripts', 'bones_fonts');







/**
 *  Resizes an image and returns an array containing the resized URL, width, height and file type. Uses native Wordpress functionality.
 *
 *  Because Wordpress 3.5 has added the new 'WP_Image_Editor' class and depreciated some of the functions
 *  we would normally rely on (such as wp_load_image), a separate function has been created for 3.5+.
 *
 *  Providing two separate functions means we can be backwards compatible and future proof. Hooray!
 *
 *  The first function (3.5+) supports GD Library and Imagemagick. Worpress will pick whichever is most appropriate.
 *  The second function (3.4.2 and lower) only support GD Library.
 *  If none of the supported libraries are available the function will bail and return the original image.
 *
 *  Both functions produce the exact same results when successful.
 *  Images are saved to the Wordpress uploads directory, just like images uploaded through the Media Library.
 *
  *  Copyright 2013 Matthew Ruddy (http://easinglider.com)
  *
  *  This program is free software; you can redistribute it and/or modify
  *  it under the terms of the GNU General Public License, version 2, as
  *  published by the Free Software Foundation.
  *
  *  This program is distributed in the hope that it will be useful,
  *  but WITHOUT ANY WARRANTY; without even the implied warranty of
  *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  *  GNU General Public License for more details.
  *
  *  You should have received a copy of the GNU General Public License
  *  along with this program; if not, write to the Free Software
  *  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 *
 *  @author Matthew Ruddy (http://easinglider.com)
 *  @return array   An array containing the resized image URL, width, height and file type.
 */
if ( isset( $wp_version ) && version_compare( $wp_version, '3.5' ) >= 0 ) {
  function matthewruddy_image_resize( $url, $width = NULL, $height = NULL, $crop = true, $retina = false ) {

    global $wpdb;

    if ( empty( $url ) )
      return new WP_Error( 'no_image_url', __( 'No image URL has been entered.','wta' ), $url );

    // Get default size from database
    $width = ( $width )  ? $width : get_option( 'thumbnail_size_w' );
    $height = ( $height ) ? $height : get_option( 'thumbnail_size_h' );

    // Allow for different retina sizes
    $retina = $retina ? ( $retina === true ? 2 : $retina ) : 1;

    // Get the image file path
    $file_path = parse_url( $url );
    $file_path = $_SERVER['DOCUMENT_ROOT'] . $file_path['path'];

    // Check for Multisite
    if ( is_multisite() ) {
      global $blog_id;
      $blog_details = get_blog_details( $blog_id );
      $file_path = str_replace( $blog_details->path . 'files/', '/wp-content/blogs.dir/'. $blog_id .'/files/', $file_path );
    }

    // Destination width and height variables
    $dest_width = $width * $retina;
    $dest_height = $height * $retina;

    // File name suffix (appended to original file name)
    $suffix = "{$dest_width}x{$dest_height}";

    // Some additional info about the image
    $info = pathinfo( $file_path );
    $dir = $info['dirname'];
    $ext = $info['extension'];
    $name = wp_basename( $file_path, ".$ext" );

          if ( 'bmp' == $ext ) {
      return new WP_Error( 'bmp_mime_type', __( 'Image is BMP. Please use either JPG or PNG.','wta' ), $url );
    }

    // Suffix applied to filename
    $suffix = "{$dest_width}x{$dest_height}";

    // Get the destination file name
    $dest_file_name = "{$dir}/{$name}-{$suffix}.{$ext}";

    if ( !file_exists( $dest_file_name ) ) {

      /*
       *  Bail if this image isn't in the Media Library.
       *  We only want to resize Media Library images, so we can be sure they get deleted correctly when appropriate.
       */
      $query = $wpdb->prepare( "SELECT * FROM $wpdb->posts WHERE guid='%s'", $url );
      $get_attachment = $wpdb->get_results( $query );
      if ( !$get_attachment )
        return array( 'url' => $url, 'width' => $width, 'height' => $height );

      // Load Wordpress Image Editor
      $editor = wp_get_image_editor( $file_path );
      if ( is_wp_error( $editor ) )
        return array( 'url' => $url, 'width' => $width, 'height' => $height );

      // Get the original image size
      $size = $editor->get_size();
      $orig_width = $size['width'];
      $orig_height = $size['height'];

      $src_x = $src_y = 0;
      $src_w = $orig_width;
      $src_h = $orig_height;

      if ( $crop ) {

        $cmp_x = $orig_width / $dest_width;
        $cmp_y = $orig_height / $dest_height;

        // Calculate x or y coordinate, and width or height of source
        if ( $cmp_x > $cmp_y ) {
          $src_w = round( $orig_width / $cmp_x * $cmp_y );
          $src_x = round( ( $orig_width - ( $orig_width / $cmp_x * $cmp_y ) ) / 2 );
        }
        else if ( $cmp_y > $cmp_x ) {
          $src_h = round( $orig_height / $cmp_y * $cmp_x );
          $src_y = round( ( $orig_height - ( $orig_height / $cmp_y * $cmp_x ) ) / 2 );
        }

      }

      // Time to crop the image!
      $editor->crop( $src_x, $src_y, $src_w, $src_h, $dest_width, $dest_height );

      // Now let's save the image
      $saved = $editor->save( $dest_file_name );

      // Get resized image information
      $resized_url = str_replace( basename( $url ), basename( $saved['path'] ), $url );
      $resized_width = $saved['width'];
      $resized_height = $saved['height'];
      $resized_type = $saved['mime-type'];

      // Add the resized dimensions to original image metadata (so we can delete our resized images when the original image is delete from the Media Library)
      $metadata = wp_get_attachment_metadata( $get_attachment[0]->ID );
      if ( isset( $metadata['image_meta'] ) ) {
        $metadata['image_meta']['resized_images'][] = $resized_width .'x'. $resized_height;
        wp_update_attachment_metadata( $get_attachment[0]->ID, $metadata );
      }

      // Create the image array
      $image_array = array(
        'url' => $resized_url,
        'width' => $resized_width,
        'height' => $resized_height,
        'type' => $resized_type
      );

    }
    else {
      $image_array = array(
        'url' => str_replace( basename( $url ), basename( $dest_file_name ), $url ),
        'width' => $dest_width,
        'height' => $dest_height,
        'type' => $ext
      );
    }

    // Return image array
    return $image_array;

  }
}
else {
  function matthewruddy_image_resize( $url, $width = NULL, $height = NULL, $crop = true, $retina = false ) {

    global $wpdb;

    if ( empty( $url ) )
      return new WP_Error( 'no_image_url', __( 'No image URL has been entered.','wta' ), $url );

    // Bail if GD Library doesn't exist
    if ( !extension_loaded('gd') || !function_exists('gd_info') )
      return array( 'url' => $url, 'width' => $width, 'height' => $height );

    // Get default size from database
    $width = ( $width ) ? $width : get_option( 'thumbnail_size_w' );
    $height = ( $height ) ? $height : get_option( 'thumbnail_size_h' );

    // Allow for different retina sizes
    $retina = $retina ? ( $retina === true ? 2 : $retina ) : 1;

    // Destination width and height variables
    $dest_width = $width * $retina;
    $dest_height = $height * $retina;

    // Get image file path
    $file_path = parse_url( $url );
    $file_path = $_SERVER['DOCUMENT_ROOT'] . $file_path['path'];

    // Check for Multisite
    if ( is_multisite() ) {
      global $blog_id;
      $blog_details = get_blog_details( $blog_id );
      $file_path = str_replace( $blog_details->path . 'files/', '/wp-content/blogs.dir/'. $blog_id .'/files/', $file_path );
    }

    // Some additional info about the image
    $info = pathinfo( $file_path );
    $dir = $info['dirname'];
    $ext = $info['extension'];
    $name = wp_basename( $file_path, ".$ext" );

          if ( 'bmp' == $ext ) {
      return new WP_Error( 'bmp_mime_type', __( 'Image is BMP. Please use either JPG or PNG.','wta' ), $url );
    }

    // Suffix applied to filename
    $suffix = "{$dest_width}x{$dest_height}";

    // Get the destination file name
    $dest_file_name = "{$dir}/{$name}-{$suffix}.{$ext}";

    // No need to resize & create a new image if it already exists!
    if ( !file_exists( $dest_file_name ) ) {

      /*
       *  Bail if this image isn't in the Media Library either.
       *  We only want to resize Media Library images, so we can be sure they get deleted correctly when appropriate.
       */
      $query = $wpdb->prepare( "SELECT * FROM $wpdb->posts WHERE guid='%s'", $url );
      $get_attachment = $wpdb->get_results( $query );
      if ( !$get_attachment )
        return array( 'url' => $url, 'width' => $width, 'height' => $height );

      $image = wp_load_image( $file_path );
      if ( !is_resource( $image ) )
        return new WP_Error( 'error_loading_image_as_resource', $image, $file_path );

      // Get the current image dimensions and type
      $size = @getimagesize( $file_path );
      if ( !$size )
        return new WP_Error( 'file_path_getimagesize_failed', __( 'Failed to get $file_path information using "@getimagesize".','wta'), $file_path );
      list( $orig_width, $orig_height, $orig_type ) = $size;

      // Create new image
      $new_image = wp_imagecreatetruecolor( $dest_width, $dest_height );

      // Do some proportional cropping if enabled
      if ( $crop ) {

        $src_x = $src_y = 0;
        $src_w = $orig_width;
        $src_h = $orig_height;

        $cmp_x = $orig_width / $dest_width;
        $cmp_y = $orig_height / $dest_height;

        // Calculate x or y coordinate, and width or height of source
        if ( $cmp_x > $cmp_y ) {
          $src_w = round( $orig_width / $cmp_x * $cmp_y );
          $src_x = round( ( $orig_width - ( $orig_width / $cmp_x * $cmp_y ) ) / 2 );
        }
        else if ( $cmp_y > $cmp_x ) {
          $src_h = round( $orig_height / $cmp_y * $cmp_x );
          $src_y = round( ( $orig_height - ( $orig_height / $cmp_y * $cmp_x ) ) / 2 );
        }

        // Create the resampled image
        imagecopyresampled( $new_image, $image, 0, 0, $src_x, $src_y, $dest_width, $dest_height, $src_w, $src_h );

      }
      else
        imagecopyresampled( $new_image, $image, 0, 0, 0, 0, $dest_width, $dest_height, $orig_width, $orig_height );

      // Convert from full colors to index colors, like original PNG.
      if ( IMAGETYPE_PNG == $orig_type && function_exists('imageistruecolor') && !imageistruecolor( $image ) )
        imagetruecolortopalette( $new_image, false, imagecolorstotal( $image ) );

      // Remove the original image from memory (no longer needed)
      imagedestroy( $image );

      // Check the image is the correct file type
      if ( IMAGETYPE_GIF == $orig_type ) {
        if ( !imagegif( $new_image, $dest_file_name ) )
          return new WP_Error( 'resize_path_invalid', __( 'Resize path invalid (GIF)','wta' ) );
      }
      elseif ( IMAGETYPE_PNG == $orig_type ) {
        if ( !imagepng( $new_image, $dest_file_name ) )
          return new WP_Error( 'resize_path_invalid', __( 'Resize path invalid (PNG).','wta' ) );
      }
      else {

        // All other formats are converted to jpg
        if ( 'jpg' != $ext && 'jpeg' != $ext )
          $dest_file_name = "{$dir}/{$name}-{$suffix}.jpg";
        if ( !imagejpeg( $new_image, $dest_file_name, apply_filters( 'resize_jpeg_quality', 90 ) ) )
          return new WP_Error( 'resize_path_invalid', __( 'Resize path invalid (JPG).','wta' ) );

      }

      // Remove new image from memory (no longer needed as well)
      imagedestroy( $new_image );

      // Set correct file permissions
      $stat = stat( dirname( $dest_file_name ));
      $perms = $stat['mode'] & 0000666;
      @chmod( $dest_file_name, $perms );

      // Get some information about the resized image
      $new_size = @getimagesize( $dest_file_name );
      if ( !$new_size )
        return new WP_Error( 'resize_path_getimagesize_failed', __( 'Failed to get $dest_file_name (resized image) info via @getimagesize','wta' ), $dest_file_name );
      list( $resized_width, $resized_height, $resized_type ) = $new_size;

      // Get the new image URL
      $resized_url = str_replace( basename( $url ), basename( $dest_file_name ), $url );

      // Add the resized dimensions to original image metadata (so we can delete our resized images when the original image is delete from the Media Library)
      $metadata = wp_get_attachment_metadata( $get_attachment[0]->ID );
      if ( isset( $metadata['image_meta'] ) ) {
        $metadata['image_meta']['resized_images'][] = $resized_width .'x'. $resized_height;
        wp_update_attachment_metadata( $get_attachment[0]->ID, $metadata );
      }

      // Return array with resized image information
      $image_array = array(
        'url' => $resized_url,
        'width' => $resized_width,
        'height' => $resized_height,
        'type' => $resized_type
      );

    }
    else {
      $image_array = array(
        'url' => str_replace( basename( $url ), basename( $dest_file_name ), $url ),
        'width' => $dest_width,
        'height' => $dest_height,
        'type' => $ext
      );
    }

    return $image_array;

  }
}

/**
 *  Deletes the resized images when the original image is deleted from the Wordpress Media Library.
 *
 */
add_action( 'delete_attachment', 'matthewruddy_delete_resized_images' );
function matthewruddy_delete_resized_images( $post_id ) {

  // Get attachment image metadata
  $metadata = wp_get_attachment_metadata( $post_id );
  if ( !$metadata )
    return;

  // Do some bailing if we cannot continue
  if ( !isset( $metadata['file'] ) || !isset( $metadata['image_meta']['resized_images'] ) )
    return;
  $pathinfo = pathinfo( $metadata['file'] );
  $resized_images = $metadata['image_meta']['resized_images'];

  // Get Wordpress uploads directory (and bail if it doesn't exist)
  $wp_upload_dir = wp_upload_dir();
  $upload_dir = $wp_upload_dir['basedir'];
  if ( !is_dir( $upload_dir ) )
    return;

  // Delete the resized images
  foreach ( $resized_images as $dims ) {

    // Get the resized images filename
    $file = $upload_dir .'/'. $pathinfo['dirname'] .'/'. $pathinfo['filename'] .'-'. $dims .'.'. $pathinfo['extension'];

    // Delete the resized image
    @unlink( $file );

  }

}






/********************************************
  Flavorlab Slider Ajax Functions
********************************************/


//
// Get all post content for all thumbnails and posts for homepage slider based on category
//
add_action('wp_ajax_fl_slider_latestTopWork', 'fl_slider_latestTopWork');
add_action( 'wp_ajax_nopriv_fl_slider_latestTopWork', 'fl_slider_latestTopWork' );

function fl_slider_latestTopWork() {
  check_ajax_referer( 'fl_slider_latestTopWork-security', 'security' );

  $catID = filter_input(INPUT_POST,'category_id',FILTER_SANITIZE_NUMBER_INT);
  $postID = filter_input(INPUT_POST,'post_id',FILTER_SANITIZE_NUMBER_INT);
  $categoryPosts = array();

  wp_reset_query();

  $catQuery = new WP_Query('cat='.$catID);

  if ($catQuery->have_posts() && is_numeric($catID)) {

    while ($catQuery->have_posts()) : $catQuery->the_post(); $do_not_duplicate = $post->ID;
      $category = get_the_category();
      $firstCategory = $category[0]->term_id;
      $fullCatName = $category[0]->name;
      $categoryPosts[] = array('post_title'=>get_the_title(), 'vimeoURL'=>get_post_custom_values('vimeo_url'), 'sliderThumbnailURL'=>get_post_custom_values('sliderThumbnailURL'), 'clientName'=>get_post_custom_values('client_name'), 'date'=>get_the_date("m-d-Y"),'post_content'=>get_the_content(), 'post_excerpt'=>get_the_excerpt(), 'show-view-case-study-link'=>get_post_custom_values('show-view-case-study-link'), 'featured_image'=>get_the_post_thumbnail( $post->ID, 'post-thumbnail'), 'cat_id'=>$firstCategory, 'post_id'=>get_the_ID(), 'cat_name'=>$fullCatName, 'post_id'=>get_the_ID(), 'featured_image_url'=>wp_get_attachment_url( get_post_thumbnail_id($post->ID)), 'fullLink'=>get_page_link());
    endwhile;

  } else {
    $categoryPosts[] = array('error'=>'Not Found');
  }

  echo json_encode($categoryPosts);

  die();

}






//
// Post content from thumbnail click
//
add_action('wp_ajax_fl_slider_thumbnailLoad', 'fl_slider_thumbnailLoad');
add_action( 'wp_ajax_nopriv_fl_slider_thumbnailLoad', 'fl_slider_thumbnailLoad' );

function fl_slider_thumbnailLoad() {
  check_ajax_referer( 'fl_slider_thumbnailLoad-security', 'security' );

  $postID = filter_input(INPUT_POST,'post_id',FILTER_SANITIZE_NUMBER_INT);
  $thePost = array();

  $postQuery = new WP_Query('p='.$postID.'');

  while ($postQuery->have_posts()) : $postQuery->the_post(); $do_not_duplicate = $post->ID;
  $thePost[] = array('post_title'=>get_the_title(), 'vimeoURL'=>get_post_custom_values('vimeo_url'), 'sliderThumbnailURL'=>get_post_custom_values('sliderThumbnailURL'), 'clientName'=>get_post_custom_values('client_name'), 'date'=>get_the_date("m-d-Y"), 'post_content'=>get_the_content(), 'post_excerpt'=>get_the_excerpt(), 'featured_image'=>get_the_post_thumbnail( $post->ID, 'post-thumbnail'), 'show-view-case-study-link'=>get_post_custom_values('show-view-case-study-link'), 'featured_image_url'=>wp_get_attachment_url( get_post_thumbnail_id($post->ID)), 'post_id'=>get_the_ID(), 'fullLink'=>get_page_link());
  endwhile;

  echo json_encode($thePost);

  die();
}
























//
// Get all subsequent posts on page load for slider area
//
add_action('wp_ajax_fl_slider_latestSlider', 'fl_slider_latestSlider');
add_action( 'wp_ajax_nopriv_fl_slider_latestSlider', 'fl_slider_latestSlider' );

function fl_slider_latestSlider() {
  check_ajax_referer( 'fl_slider_latestSlider-security', 'security' );

  $catID = filter_input(INPUT_POST,'category_id',FILTER_SANITIZE_NUMBER_INT);
  $categoryPosts = array();

  $catQuery = new WP_Query('cat='.$catID.'&post_count=999');

  while ($catQuery->have_posts()) : $catQuery->the_post(); $do_not_duplicate = $post->ID;
    $categoryPosts[] = array('post_title'=>get_the_title(), 'vimeoURL'=>get_post_custom_values('vimeo_url'), 'clientName'=>get_post_custom_values('client_name'), 'date'=>get_the_date("m-d-Y"), 'post_content'=>get_the_content(), 'post_excerpt'=>get_the_excerpt(), 'featured_image'=>get_the_post_thumbnail( $post->ID, 'post-thumbnail'), 'post_id'=>get_the_ID(), 'fullLink'=>get_page_link(), 'featured_image_url'=>wp_get_attachment_url( get_post_thumbnail_id($post->ID)));
  endwhile;

  echo json_encode($categoryPosts);

  die();
}













/* DON'T DELETE THIS CLOSING TAG */ ?>
