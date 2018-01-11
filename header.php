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
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

	<title><? wp_title(); ?></title>
	<? wp_head(); ?>
	
	<link rel="stylesheet" href="/css/openskull.css"/>
	<link rel="stylesheet" href="/css/style.css"/>
</head>
<body <?php body_class(); ?>>
	<div class="header_outer row">
		<button class="os_menu_toggle" aria-controls="primary-menu" aria-expanded="false"></button>

		<header class="header row">
			<a href="/" class="logo"><img src="/img/logo.png" alt=""/></a>
			
			<nav class="os-mainmenu pull-right row">
				<?php wp_nav_menu( array( 
					'menu' => 'Main Menu', 
					'menu_id' => 'primary-menu'
				));?>
			</nav>
		</header>
	</div>
	<main class="content_outer">
		<div class="content">