<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WP_Bootstrap_Starter
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <!--<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/fontawesome-free-5.0.10/fontawesome.js"></script>-->
    <script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/fontawesome-free-5.0.10/svg-with-js/js/fontawesome.js"></script>
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'wp-bootstrap-starter' ); ?></a>
    <?php if(!is_page_template( 'blank-page.php' ) && !is_page_template( 'blank-page-with-container.php' )): ?>
	<header id="masthead1" class="site-header navbar-static-top <?php echo wp_bootstrap_starter_bg_class(); ?>" role="banner">
        <div class="container">
            <nav class="navbar navbar-expand-xl p-0">
                <div class="navbar-brand">
                    <?php if ( get_theme_mod( 'wp_bootstrap_starter_logo' ) ): ?>
                        <a href="<?php echo esc_url( home_url( '/' )); ?>">
                            <img src="<?php echo esc_attr(get_theme_mod( 'wp_bootstrap_starter_logo' )); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
                        </a>
                    <?php else : ?>
                        <a class="site-title" href="<?php echo esc_url( home_url( '/' )); ?>"><?php esc_url(bloginfo('name')); ?></a>
                    <?php endif; ?>

                </div>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".navbar-collapse" aria-controls="" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <?php
                wp_nav_menu(array(
                'theme_location'    => 'primary',
                'container'       => 'div',
                'container_id'    => '',
                'container_class' => 'collapse navbar-collapse justify-content-end',
                'menu_id'         => false,
                'menu_class'      => 'navbar-nav',
                'depth'           => 3,
                'fallback_cb'     => 'wp_bootstrap_navwalker::fallback',
                'walker'          => new wp_bootstrap_navwalker()
                ));
                ?>

            </nav>
        </div>
	</header><!-- #masthead -->
    <?php if(is_front_page() && !get_theme_mod( 'header_banner_visibility' )): ?>
        <div id="page-sub-header1" <?php if(has_post_thumbnail()) { ?>style="background-image: url('<?php the_post_thumbnail_url('full'); ?>');" <?php } ?>>
            <div class="container">
                <div class="site-desc-front">
                    <h1>
                        <?php echo get_bloginfo( 'name' ); ?>
                    </h1>
                    <h2 class="additional-description">
                        <?php echo get_bloginfo( 'description' ); ?>
                    </h2>
                    <div class="site-desc-front-desc-text">
                        <p>
                            <?php _e("Oletko hakemassa osaajaa vai olet ehkä osaaja ilman haasteita?<br />
                            Löydä osaaja on Satakunnan ammattikorkeakoulun hallinnoima rekrykanava, joka yhdistää tekijät,osaajat ja työnantajat.","sivun-paa-mainosteksti-1"); ?>
                        </p>
                        <p>
                           <strong><?php _e("Liity rohkeasti osaajiin ja rekisteröidy.","liity-rohkeasti-osaajiin-ja-rekisteroidy"); ?></strong>
                        </p>             
                    </div>

                    <div class="row site-desc-front-links equal-heights">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 employee-holder block-link-holder">
                            <a href="<?php echo get_permalink(76); ?>" aria-label="Rekisteröidy tästä osaajaksi">
                                <p><strong><?php _e("Oletko osaaja?","oletko-osaaja"); ?></strong></p>
                                <p><?php _e("Rekisteröidy palveluun ja kesätyö- tai harjoittelupaikka on askeleen lähempänä","rekisteroidy-mainos-teksti-1"); ?></p>
                            </a>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 employer-holder block-link-holder">
                            <a href="<?php echo get_permalink(80); ?>" aria-label="Rekisteröidy tästä työnantajaksi palveluun">
                                <p><strong><?php _e("Oletko työnantaja?","oletko-tyonantaja"); ?></strong></p>
                                <p><?php _e("Rekisteröidy palveluun ja löydä osaaja","rekisteroidy-palveluun-ja-loyda-osaaja"); ?></p>
                            </a>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 readmore-holder block-link-holder">
                            <a class="smooth-scroll" href="#content" aria-label="Lue lisää tästä palvelusta">
                                <p><strong><?php _e("Mikä on Löydä osaaja?","mika-on-loyda-osaaja"); ?></strong></p>
                                <p><?php _e("Tutustu palveluumme","tutustu-palveluumme"); ?></p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
	<div id="content" class="site-content">
		<div class="container-fluid">
			<div>
                <?php endif; ?>