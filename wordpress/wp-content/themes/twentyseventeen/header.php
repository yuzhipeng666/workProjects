<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<!--<meta name="viewport" content="width=device-width, initial-scale=1">-->
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" >
<link rel="profile" href="http://gmpg.org/xfn/11">
<!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.0.0/css/swiper.css">-->
<!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.0.0/css/swiper.min.css">-->
<script src="http://g.tbcdn.cn/mtb/lib-flexible/0.3.4/??flexible_css.js,flexible.js"></script>
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.3.5/js/swiper.js"></script>-->
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.3.5/js/swiper.min.js"></script>-->
<script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.min.js"></script>

<?php wp_head();
$defaults = array(
    'theme_location' => '',
    'menu'      => 'header_menu',
    'container'    => 'div',
    'container_class' => '',
    'container_id'  => '',
    'menu_class'   => 'menu',
    'menu_id'     => '',
    'echo'      => true,
    'fallback_cb'   => 'wp_page_menu',
    'before'     => '',
    'after'      => '',
    'link_before'   => '',
    'link_after'   => '',
    'items_wrap'   => '<ul id="%1$s" class="%2$s">%3$s</ul>',
    'depth'      => 0,
    'walker'     => ''
);
?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<header id="masthead" class="site-header" role="banner">
		<nav class="header-ul">
            <div class="logo">
                <a href="http://china.xblockchain.tech/">
                    <img src="/wp-content/themes/twentyseventeen/assets/images/logo-white-1.png" alt="" >
                </a>
                <div class="icon-close">
                    <span></span>
                    <span></span>
                </div>
            </div>
            <?php wp_nav_menu( $defaults );?>
            <div class="clear"></div>
        </nav>
	</header><!-- #masthead -->

	<?php

	/*
	 * If a regular post or page, and not the front page, show the featured image.
	 * Using get_queried_object_id() here since the $post global may not be set before a call to the_post().
	 */
	if ( ( is_single() || ( is_page() && ! twentyseventeen_is_frontpage() ) ) && has_post_thumbnail( get_queried_object_id() ) ) :
		echo '<div class="single-featured-image-header">';
		echo get_the_post_thumbnail( get_queried_object_id(), 'twentyseventeen-featured-image' );
		echo '</div><!-- .single-featured-image-header -->';
	endif;
	?>

	<div class="site-content-contain">
		<div id="content" class="site-content">


