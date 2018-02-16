
<!--
	Website Made By
   ____ _                         _      ____                _   _           
  / ___| | __ _ _   _ _ __   ___ | |_   / ___|_ __ ___  __ _| |_(_)_   _____ 
 | |   | |/ _` | | | | '_ \ / _ \| __| | |   | '__/ _ \/ _` | __| \ \ / / _ \
 | |___| | (_| | |_| | |_) | (_) | |_  | |___| | |  __/ (_| | |_| |\ V /  __/
  \____|_|\__,_|\__, | .__/ \___/ \__|  \____|_|  \___|\__,_|\__|_| \_/ \___|
                |___/|_|                                                     
	http://claypotcreative.com/
-->

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

	<link rel="shortcut icon" href="/img/favicon.png" />
</head>
<body <?php body_class(); ?>>
	<div class="header_outer row">
		<button class="os_menu_toggle" aria-controls="primary-menu" aria-expanded="false"></button>

		<div class="top_outer">
			<div class="top container"></div>
		</div>

		<header class="header container">
			<a href="/" class="logo"><img src="/img/logo.png" alt=""/></a>
			
			<nav class="os-mainmenu pull-right row">
				<?php wp_nav_menu( array( 
					'menu' => 'Main Menu', 
					'menu_id' => 'primary-menu'
				));?>
			</nav>

			<div class="search"></div>
		</header>
	</div>
	<main class="content_outer">
		<div class="content">