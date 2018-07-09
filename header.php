
<!--
	Website Made By
  _____ _               _____      _      _____                _   _           
 / ____| |             |  __ \    | |    / ____|              | | (_)          
| |    | | __ _ _   _  | |__) |__ | |_  | |     _ __ ___  __ _| |_ ___   _____ 
| |    | |/ _` | | | | |  ___/ _ \| __| | |    | '__/ _ \/ _` | __| \ \ / / _ \
| |____| | (_| | |_| | | |  | (_) | |_  | |____| | |  __/ (_| | |_| |\ V /  __/
 \_____|_|\__,_|\__, | |_|   \___/ \__|  \_____|_|  \___|\__,_|\__|_| \_/ \___|
                 __/ |                                                         
                |___/                                                                                                       
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
	<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> 

	<title><? wp_title(); ?></title>

	<?php if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' ); ?>
	<? wp_head(); ?>
	
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" href="/css/style.php"/>

	<link rel="shortcut icon" href="/img/favicon.png?" type="image/x-icon" />
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