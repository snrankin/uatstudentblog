<!DOCTYPE html>
    <html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>" />
        <meta name="viewport" content="width=device-width" />
        <title><?php wp_title( ' | ', true, 'right' ); ?></title>
        <link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_uri(); ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(); ?>/fonts/FontAwesome/css/font-awesome.min.css" />
        <?php wp_head(); ?>
    </head>
    <body <?php body_class(); ?>>
    	<nav id="menu" role="navigation">
        	<div class="inner">
				<?php wp_nav_menu( array( 'theme_location' => 'main-menu' ) ); ?>
                <div id="search">
                    <?php get_search_form(); ?>
                </div>
            </div>
        </nav>
        <div id="wrapper" class="hfeed">
            <header id="header" role="banner">
            	<div class="inner">
                    <section id="branding">
                        <div id="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php esc_attr_e( get_bloginfo( 'name' ), 'blankslate' ); ?>" rel="home"><img src="<?php echo get_template_directory_uri(); ?>/imgs/UATlogo.png" width="100"></a><?php if ( ! is_singular() ) { echo '<h1>'; } ?><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php esc_attr_e( get_bloginfo( 'name' ), 'blankslate' ); ?>" rel="home"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></a><?php if ( ! is_singular() ) { echo '</h1>'; } ?></div>
                        <div id="site-description"><?php bloginfo( 'description' ); ?></div>
                    </section>
                </div>
            </header>
            <div id="container">
            	<div class="inner">