<?php
/**
 * The Header for our theme.
 *
 */
?><!DOCTYPE html>
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
<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0">

<title><?php wp_title( '|', true, 'right' ); ?></title>

<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="wrapper" class="hfeed">
<?php do_action( 'before' ); ?>
	<header id="header" role="banner">
		<hgroup>
			<?php $heading_tag = ( is_home() || is_front_page() ) ? 'h1' : 'div'; ?>
				<<?php echo $heading_tag; ?> id="site-title"><a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></<?php echo $heading_tag; ?>>
			<?php $description_tag = ( is_home() || is_front_page() ) ? 'h2' : 'div'; ?>
				<<?php echo $description_tag; ?> id="site-description"><?php bloginfo( 'description' ); ?></<?php echo $description_tag; ?>>
		</hgroup>
		<div class="clearfix">&nbsp;</div>
		<nav id="access" class="main-navigation" role="navigation">
			<h1 class="assistive-text section-heading"><?php _e( 'Menu', 'tvdefault' ); ?></h1>
			<div class="skip-link screen-reader-text"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'tvdefault' ); ?>"><?php _e( 'Skip to content', 'tvdefault' ); ?></a></div>
			<div class="clearfix ma-hide">&nbsp;</div>
			<div class="menu-assist">
				<div class="btn">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</div>
				<div class="clearfix">&nbsp;</div>
			</div>
			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'fallback_cb' => false, 'depth' => 4 ) ); ?>
		</nav><!-- #access -->
	</header><!-- #header -->

	<div id="main">
