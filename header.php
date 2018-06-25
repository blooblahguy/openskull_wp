
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
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

	<title><? wp_title(); ?></title>

	<?php if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' ); ?>
	<? wp_head(); ?>
	
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" href="/css/openskull.css"/>
	<link rel="stylesheet" href="/css/style.php"/>

	<link rel="shortcut icon" href="/img/favicon.png" />
</head>
<body <?php body_class(); ?>>
	
	<div class="top_outer">
		<div class="top container">
			
		</div>
	</div>
	<div class="header_outer bg-primary ">
		<button class="os_menu_toggle hidden-md hidden-lg" aria-controls="primary-menu" aria-expanded="false">
			<span></span>
			<span></span>
			<span></span>
		</button>

		<div class="container">

		<header class="header row content-justify content-middle">
			<a href="/" class="logo os ">Atlas</a>
			
			<nav class="os os-menu self-end">
				<?php wp_nav_menu( array( 
					'menu' => 'Main Menu' 
					, 'menu_id' => 'primary-menu'
					, 'menu_class' => 'os-menu menu'
				));?>
			</nav>

			<? //get_search_form() ?>
		</header>
		</div>
	</div>
	<main class="content_outer padb40">
		<div class="content">