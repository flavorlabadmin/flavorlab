<?php
// Check for URL parameter.
// If we have URL parameter, do if else for company name
// show score-header / ptb-header / homepage-header (default) / sound-header.php files in includes
// if nothing is found default to the FL home header
//
// Do the same as above for the news header, ex: FLAVORNEWS / SCORENEWS / SOUNDNEWS
//
?>
<?php
  $c = preg_replace('/[^-a-zA-Z0-9_]/', '', $_GET['c']);
  if ($c == 'score'){
    include('score-header.php');
  } else if ($c == 'sound'){
    include('sound-header.php');
  } else if ($c == 'ptb'){
    include('ptb-header.php');
  } else {
    include('default-header.php');
  }
?>