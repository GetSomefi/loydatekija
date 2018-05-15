<?php
/**
 * Template Name: Frontpage template
 */

get_header();
?>
    <div class="container">
        <section id="primary" class="content-area">
            <main id="main" class="site-main" role="main">
                <div class="container">
                    <?php
                    while ( have_posts() ) : the_post();
                        get_template_part( 'template-parts/content', 'notitle' );
                    endwhile; // End of the loop.
                    ?>
                </div>
            </main><!-- #main -->
        </section><!-- #primary -->
    </div>
    <section class="how-it-works row" aria-labeledby="how-it-works">
        <div class="container">
            <h2 id="how-it-works"><?php _e("Näin se toimii!"); ?></h2>
            <div class="row hiw-employer">
                <div class="col-12">
                    <h3>Työnantaja</h3>
                </div>
                <div class="col-md-3">
                    <div class="hiw-icon">
                        <i class="far fa-address-card"></i>
                    </div>
                    <div class="hiw-text">
                        1. <?php _e("Rekisteröidy"); ?>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="hiw-icon">
                        <i class="fab fa-wpforms"></i>
                    </div>
                    <div class="hiw-text">
                        2. <?php _e("Tee ilmoitus"); ?>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="hiw-icon">
                        <i class="far fa-clock"></i>
                    </div>
                    <div class="hiw-text">
                        3. <?php _e("Odota"); ?>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="hiw-icon">
                        <i class="fas fa-handshake"></i>
                    </div>
                    <div class="hiw-text">
                        4. <?php _e("Palkkaa tekijä"); ?>
                    </div>
                </div>
            </div>
            <div class="row hiw-student">
                <div class="col-12">
                    <h3>Opiskelija</h3>
                </div>
                <div class="col-md-3">
                    <div class="hiw-icon">
                        <i class="far fa-address-card"></i>
                    </div>
                    <div class="hiw-text">
                        1. <?php _e("Rekisteröidy"); ?>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="hiw-icon">
                        <i class="fas fa-hand-paper"></i>
                    </div>
                    <div class="hiw-text">
                        2. <?php _e("Ilmianna itsesi"); ?>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="hiw-icon">
                        <i class="far fa-clock"></i>
                    </div>
                    <div class="hiw-text">
                        3. <?php _e("Odota"); ?>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="hiw-icon">
                        <i class="fas fa-handshake"></i>
                    </div>
                    <div class="hiw-text">
                        4. <?php _e("Mene haastatteluun"); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php
get_footer();
