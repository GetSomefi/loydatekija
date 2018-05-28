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

				<br />
				<a class="beat-general-link" href="<?php echo esc_url( get_permalink(41) ); ?>">Takaisin ilmoituksiin</a>

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

				$user_name = get_the_author_meta('display_name');
				$user_desc = get_the_author_meta('description');
				$user_address = get_the_author_meta( 'homeaddress' );
                $user_phone = get_the_author_meta( 'phone' );
                $user_email = get_the_author_meta( 'email' );
                $user_firstname = get_the_author_meta( 'first_name' );
                $user_lastname = get_the_author_meta( 'last_name' );

				echo "<div class='more-info-name'>";
					echo "<h3>";
						echo $user_name;
					echo "</h3>";
				echo "</div>";

				echo "<div>";
					echo "<p>";
						echo $user_desc;
					echo "</p>";
				echo "</div>";
				?>
				<?php if( get_field('piilota_yhteystiedot_') == "no" ): ?>
                  <div class="beat-job-contact-info">
                    <h3><?php _e("Yhteys","yhteys"); ?></h3>
                    <?php
                    if( get_field('nimi') == "" ){
                    echo $user_lastname . " " . $user_firstname . "<br />";
                    }else{
                      echo get_field('nimi') . "<br />";
                    }

                    if( get_field('sahkoposti') == "" ){
                      echo $user_email . "<br />";
                    }else{
                      echo get_field('sahkoposti') . "<br />";
                    }

                    if( get_field('puhelin') == "" ){
                      echo $user_phone . "<br />";
                    }else{
                      echo get_field('puhelin');
                    }
                    ?>
                  </div>
                  <?php endif; ?>

			</section>
		</div>
	</div>
<?php
//get_sidebar();
get_footer();
