<?php
/**
 * @package WordPress
 * Template Name: Asiakaspuoli template
 */
?>
<?php
get_header(); ?>
	<div class="container">
		<div class="row">
			<section id="primary" class="content-area col-sm-12 col-lg-8">
				<main id="main" class="site-main" role="main">

				<?php
				while ( have_posts() ) : the_post();

					get_template_part( 'template-parts/content', get_post_format() );

					    the_post_navigation();

					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;

				endwhile; // End of the loop.
				?>

				</main><!-- #main -->
			</section><!-- #primary -->
			<section id="author-section-right" class="col-sm-12 col-lg-4">
				<?php 
				$authorID = get_the_author_meta( 'ID' );

				um_fetch_user( $authorID );

				$user_name = um_user('display_name');
				$user_desc = get_the_author_meta('description');

				echo "<div class='more-info-name'>";
					echo "<h3>";
						echo $user_name;
					echo "</h3>";
				echo "</div>";

				$content = um_convert_tags( um_get_option('profile_desc') );
				$user_id = um_user('ID');
				
				$url = um_user_profile_url();
				if ( um_profile('cover_photo') ) {
						$cover_uri = um_get_cover_uri( um_profile('cover_photo'), null );
				} else if( um_profile('synced_cover_photo') ) {
						$cover_uri = um_profile('synced_cover_photo');
			        }else{
						$cover_uri = um_get_default_cover_uri();
						
				}
				//$cover = um_get_cover_uri( um_profile('cover_photo'), null );
				$avatar = um_get_avatar_uri( um_profile('profile_photo'), 120 );
				
				echo "<div class='more-info-parent' style='background-image:url(".$cover_uri.")'>";
					echo "<div class='more-info-avatar'><div><img src='" . $avatar . "'  alt='". $user_name ."'></div></div>";
				echo "</div>";
				
				echo "<div>";
					echo "<p>";
						echo $user_desc;
					echo "</p>";
				echo "</div>";

				um_reset_user();
				
				?>

			</section>
		</div>
	</div>
<?php
//get_sidebar();
get_footer();
