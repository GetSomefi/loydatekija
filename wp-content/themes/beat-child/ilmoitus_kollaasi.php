<?php
/**
 * @package WordPress
 * Template Name: Ilmoitus kollaasi
 */
?>

<?php get_header(); ?>

<style type="text/css">
div#ww {
    width: 100%;
}
</style>

<div id="ww">
    <div class="container">
      <div>

          <div>
            <h1>
              <?php echo get_the_title(); ?>
            </h1>
            <?php 
              $week_now = date('W');
              $date_now = date('d.m.Y');
             
              $user = wp_get_current_user();
               
            if( $user->exists() ):
            ?>
            <h3>
              Moikka <?php echo wp_get_current_user()->user_login; ?>,<br />
              Alla näet uusimmat ilmoitukset työ- ja harjoittelupaikoista.
            </h3>
            <p>
              Tänään on <?php echo $date_now; ?>, viikko <?php echo $week_now; ?>    
            </p>
            <?php
            endif;
            ?>
          </div>
          <div class="panel-group" id="all-jobs-list" role="tablist" aria-multiselectable="true">
            <div class="row">
            <?php
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
              $query = new WP_Query( $args );
              $i = 1; 
            ?>
            <?php if ( $query->have_posts() ) { ?>
              <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                <?php $i++; ?>  
                <?php
                  $format_in = 'Ymd'; // the format your value is saved in (set in the field options)
                  $format_out = 'd.m.Y'; // the format you want to end up with
                  $format_out_week = 'W'; // the format you want to end up with

                  $date_start = DateTime::createFromFormat($format_in, get_field('haku_alkaa') );
                  //echo $date->format( $format_out );
                  $date_end = DateTime::createFromFormat($format_in, get_field('haku_loppuu') );
                  //echo $date_end->format( $format_out );
                  
                  $duration_s = $date_start->format( $format_out_week );
                  $duration_s_asdays = $date_start->format( $format_out );
                  $duration_s = intval( $duration_s );                  
                  $duration_e = $date_end->format( $format_out_week );
                  $duration_e_asdays = $date_end->format( $format_out );
                  $duration_e = intval( $duration_e );
                  $duration = $duration_e - $duration_s;

                  
                  $now = time(); // or your date as well
                  $your_date = strtotime(get_field('haku_loppuu'));
                  $datediff = $your_date - $now;

                  $datediff = floor($datediff / (60 * 60 * 24)) + 1;
                ?>

                <div class="col-xs-12 col-sm-6 col-md-6">
                  <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="heading-<?php echo $i; ?>">
                      <div class="panel-title">
                        <button class="title-button" role="button" data-toggle="collapse" data-parent="#cal-accordion" href="#collapse-<?php echo $i; ?>" aria-expanded="true" aria-controls="collapse-<?php echo $i; ?>">
                          
                          <?php
                          $note = "";
                          if( $datediff < 7 && $datediff > 0 ){
                          ?>
                          <div class="alert alert-warning">
                            <h5>Hakuaikaa on <?php echo $datediff; ?> päivää jäljellä</h5>
                          </div>
                          <?php
                          }
                          if( $datediff == 0 ){
                          ?>
                          <div class="alert alert-danger">
                            <h5>Huomio! Hakuaika päättyy tänään</h5>
                          </div>
                          <?php
                          }
                          ?>
                          <?php
                          if( $datediff < 0 ){
                            $note = "ended";
                          ?>
                          <div>
                            <div class="alert alert-success">
                              <i class="fas fa-check"></i>
                              <span>
                                Haku on päättynyt<br />
                                <?php echo $duration_e_asdays; ?>
                              </span>
                            </div>
                          </div>
                          <?php
                          }
                          ?>

                          <div style="clear:both;">
                            <h3>
                              <?php the_title(); ?>
                            </h3>
                          </div>
                          <?php if( $note != "ended" ){ ?>
                          <div style="clear:both;"> 
                            <b>Hakuaika:</b> <?php echo $duration_s_asdays; ?> - <?php echo $duration_e_asdays; ?>
                          </div>
                          <?php } ?>

                        </button>
                      </div>
                    </div>
                    <div id="collapse-<?php echo $i; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-<?php echo $i; ?>">
                      <div class="panel-body">
                        <div class="panel-link">
                          <a href="<?php the_permalink(); ?>">
                            Lue koko ilmoitus
                          </a>
                        </div>
                        <?php the_content(); ?>
                        <div class="panel-link">
                          <a href="<?php the_permalink(); ?>">
                            Lue koko ilmoitus
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>


              <?php endwhile; wp_reset_postdata(); ?>
            <?php } ?>


           
          </div>


      </div>
    </div>
  </div>
</div><!-- /container -->

<?php get_footer(); ?>