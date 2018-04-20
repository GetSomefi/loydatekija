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

					//the_post_navigation();
					
					
						$args = array( 
							'post_type' => 'asiakaspuoli',
							//'category' => 6, 

							
							'posts_per_page' => 20, 
							'meta_key'       => 'haku_loppuu',
							'order'          => 'ASC',
							'orderby'       => 'meta_value',
							'no_found_rows'  => true,
							'meta_query'     => array(array(
							  'key'    => 'haku_loppuu',
							  'value'  => date('Ymd', strtotime("-1 week")),
							  'compare'=> '>=',
							  'type'   => 'NUMERIC'
							))
							
						);
						$q = new WP_Query( $args );
						//$q = $q->posts;
	 					//print_r($q);

	 					
	 					$pid = get_the_ID();
	 					/*
	 					echo "<p>" . $pid . "</p>";
	 					foreach ($q as $key => $value) {
	 						echo "<p>" . $key ."=>". $value . "</p>";
	 					}
	 					*/

	 					$id_list = array();
						while($q->have_posts()) : $q->the_post();
							$id_list[] = get_the_ID();
						endwhile;
						wp_reset_postdata(); // reset the query

						//print_r($id_list);
						$cur_pos = array_search($pid,$id_list);
						//echo "<br>";
						//echo $cur_pos;
						//echo "<br>";

						if( $cur_pos-1 >= 0 ){
							echo "<a class='beat-general-link' href='" . get_the_permalink( $id_list[$cur_pos-1] ) . "' title='" . get_the_title( $id_list[$cur_pos-1] ) . "'>";
								echo get_the_title( $id_list[$cur_pos-1] );
							echo "</a>";
						}

						if( $cur_pos+1 < sizeof($id_list) ){
							echo "<a class='beat-general-link beat-on-right' href='" . get_the_permalink( $id_list[$cur_pos+1] ) . "' title='" . get_the_title( $id_list[$cur_pos+1] ) . "'>";
								echo get_the_title( $id_list[$cur_pos+1] );
							echo "</a>";
						}
	 						 				

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
