<!DOCTYPE html>
<!--[if IE 6]>
<html id="ie6" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 7]>
<html id="ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<title><? wp_title(); ?></title>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<? wp_head(); ?>
	
	<link rel="stylesheet" href="/css/openskull.css"/>
	<link rel="stylesheet" href="/css/style.css"/>
</head>
<body <?php body_class(); ?>>
	<div class="header_outer">
		<div class="header">
			<a href="/" class="logo"><img src="logo.png" alt=""/></a>
		</div>
	</div>
	<div class="content_outer">
		<div class="content">