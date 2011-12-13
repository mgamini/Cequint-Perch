<!doctype html>
<!--[if lt IE 7 ]> <html lang="en" class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title><?php echo $thisPage ; ?></title>
<meta name="description" content="">
<meta name="author" content="">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="shortcut icon" href="/favicon.ico">
<link rel="apple-touch-icon" href="/apple-touch-icon.png">
<link rel="stylesheet" href="css/1140.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/style.css?v=2">
<link rel="stylesheet" media="handheld" href="css/handheld.css?v=2">
<script type="text/javascript" src="js/css3-mediaqueries.js"></script>
<script src="js/libs/modernizr-1.7.min.js"></script>
<?php if ($thisPage=="Our Story") 
      include('phpincludes/carousel.php'); ?>
</head>
<body class="home blog">

<div id="headWrapper" class="container">
  <header id="header" class="row">
    <div id="branding" class="threecol" role="main"> <a href="http://localhost/perch/" title="Localpress" rel="home"><?php perch_content('Logo');?> </a> </div>
    <div id="access" role="navigation" class="ninecol last">
      <div class="skip-link screen-reader-text"><a href="#content" title="Skip to content"> Skip to content </a></div>
      <?php include('phpincludes/nav.php'); ?>
    </div>
  </header>
</div>