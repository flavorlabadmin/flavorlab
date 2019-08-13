<!doctype html>

<!--[if lt IE 7]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"><![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->

	<head>
		<meta charset="utf-8">

		<?php // force Internet Explorer to use the latest rendering engine available ?>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">

		<title><?php wp_title(''); ?></title>

		<meta name="HandheldFriendly" content="True">
		<meta name="MobileOptimized" content="320">
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no"/>

		<link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/library/images/apple-touch-icon.png">
		<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/favicon.png">
		
		<link rel="preload" href="<?php echo get_template_directory_uri(); ?>/library/fonts/laurel-wreath-webfont.woff" as="font" type="font/woff" crossorigin>
		<link rel="preload" href="<?php echo get_template_directory_uri(); ?>/library/fonts/laurel-wreath-webfont.woff2" as="font" type="font/woff2" crossorigin>
		
		<!--[if IE]>
			<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico">
		<![endif]-->

		<meta name="msapplication-TileColor" content="#f01d4f">
		<meta name="msapplication-TileImage" content="<?php echo get_template_directory_uri(); ?>/library/images/win8-tile-icon.png">
    <meta name="theme-color" content="#121212">

		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

		<link href='https://fonts.googleapis.com/css?family=Lato:400,300,700|Oswald:400,300' rel='stylesheet' type='text/css'>
		<link href='https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' rel='stylesheet' type='text/css'>
		<?php wp_head(); ?>

		<?php echo get_option('fl_analytics_code'); ?>

    <script type='text/javascript' src='<?php echo get_template_directory_uri(); ?>/library/js/flex.js'></script>
    
    <!-- Global site tag (gtag.js) - Google Analytics -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=UA-32822607-1"></script>
		<script>
		  window.dataLayer = window.dataLayer || [];
		  function gtag(){dataLayer.push(arguments);}
		  gtag('js', new Date());

		  gtag('config', 'UA-32822607-1');
		</script>

	</head>

	<body <?php body_class(); ?> itemscope itemtype="http://schema.org/WebPage">

    <div id="loading"><div>LOADING</div></div>
		<div id="container">

      <?php $classes = get_body_class(); 
      if (in_array('page-template-page-homepage',$classes)) { ?>
       		<?php include_once('includes/homepage-header.php'); ?>
      <?php } else if (in_array('page-template-page-score',$classes)) { ?>
        	<?php include_once('includes/score-header.php'); ?>
      <?php } else if (in_array('page-template-page-sound',$classes)) { ?>
        	<?php include_once('includes/sound-header.php'); ?>
      <?php } else if (in_array('page-template-page-producerstoolbox',$classes)) { ?>
        	<?php include_once('includes/ptb-header.php'); ?>
      <?php } else if (is_page(997)) { ?> 
      		<?php include_once('includes/ptb-header.php'); ?> 
      <?php } else if (in_array('page-template-page-alt',$classes)) { ?>
        	<?php include_once('includes/homepage-header.php'); ?>
      <?php } else if (in_array('page-template-page-info',$classes)) { ?>
        	<?php include_once('includes/homepage-header.php'); } ?>
