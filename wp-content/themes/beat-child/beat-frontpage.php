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
<?php
get_footer();
