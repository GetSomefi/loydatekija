<?php
/**
 * @package WordPress
 * Template Name: Ilmoitus kollaasi
 */
?>

<?php get_header(); ?>

<style type="text/css">
.calendar-block{
  background: #59bebe;
  padding: 15px;
}
#cal-accordion button.title-button {
  background: none !important;
  border: none;
  -webkit-appearance: none !important;
  width: 100%;
  text-align: left;
}
#cal-accordion .alert.alert-success{
  text-align: center;
}

#cal-accordion .alert.alert-success span {
  font-size: 2.4em;
}
.cal-ended h5 {
  line-height: 3.2em;
  font-size: 1em;
}
#cal-accordion h3 {
  margin-top: 5px;
}
.panel-body a {
  padding: 10px;
  background: #59bebe;
  color: #FFF;
  font-weight: bold;
}
.panel-body a:hover {
  background: #f2f2f2;
  color: #333333;
}
</style>

<div id="ww">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-lg-offset-2 centered">
          
          <div>
            <?php $week_now = date('W'); ?>
            <h2>Its now week <?php echo $week_now; ?></h2>
          </div>
          <div class="panel-group" id="cal-accordion" role="tablist" aria-multiselectable="true">
            <?php
              //$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
              $args = array( 
                  'post_type' => 'post',
                  'category' => 6, 

                  'posts_per_page' => 20, 
                  'meta_key'       => 'tapahtuman__loppupaivamaara',
                  'order'          => 'ASC',
                  'orderby'       => 'meta_value',
                  'no_found_rows'  => true,
                  'meta_query'     => array(array(
                      //'key'    => 'tapahtuman_paivamaara',
                      //'key'    => 'tapahtuman_alkupaivamaara',
                      'key'    => 'tapahtuman__loppupaivamaara',
                      // exact date 'value'  => date('Ymd'),
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

                  $date_start = DateTime::createFromFormat($format_in, get_field('tapahtuman_alkupaivamaara') );
                  //echo $date->format( $format_out );
                  $date_end = DateTime::createFromFormat($format_in, get_field('tapahtuman__loppupaivamaara') );
                  //echo $date_end->format( $format_out );
                  
                  $duration_s = $date_start->format( $format_out_week );
                  $duration_s_asdays = $date_start->format( $format_out );
                  $duration_s = intval( $duration_s );                  
                  $duration_e = $date_end->format( $format_out_week );
                  $duration_e_asdays = $date_end->format( $format_out );
                  $duration_e = intval( $duration_e );
                  $duration = $duration_e - $duration_s;

                  
                  $now = time(); // or your date as well
                  $your_date = strtotime(get_field('tapahtuman__loppupaivamaara'));
                  $datediff = $your_date - $now;

                  $datediff = floor($datediff / (60 * 60 * 24)) + 1;
                ?>

                <div class="panel panel-default">
                  <div class="panel-heading" role="tab" id="heading-<?php echo $i; ?>">
                    <div class="panel-title">
                      <button class="title-button" role="button" data-toggle="collapse" data-parent="#cal-accordion" href="#collapse-<?php echo $i; ?>" aria-expanded="true" aria-controls="collapse-<?php echo $i; ?>">
                        
                        <?php
                        $note = "";
                        if( $datediff < 7 && $datediff > 0 ){
                        ?>
                        <div class="alert alert-warning">
                          <h5>Notice! <?php echo $datediff; ?> days left</h5>
                        </div>
                        <?php
                        }
                        if( $datediff == 0 ){
                        ?>
                        <div class="alert alert-danger">
                          <h5>Notice! This is the last day to participate</h5>
                        </div>
                        <?php
                        }
                        ?>
                        <?php
                        if( $datediff < 0 ){
                          $note = "ended";
                        ?>
                        <div>
                          <div class="col-xs-1 alert alert-success">
                            <span class="glyphicon glyphicon-check"></span>
                          </div>
                          <div class="col-xs-11 cal-ended">
                            <h5>Ended at <?php echo $duration_e_asdays; ?></h5>
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
                          <b>Course schedule</b><br />
                          <!-- Week: <?php echo $duration_s; ?><br /> -->
                          End date: <?php echo $duration_e_asdays; ?>
                        </div>
                        <?php } ?>

                      </button>
                    </div>
                  </div>
                  <div id="collapse-<?php echo $i; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-<?php echo $i; ?>">
                    <div class="panel-body">
                      <?php the_content(); ?>
                    </div>
                  </div>
                </div>


              <?php endwhile; wp_reset_postdata(); ?>
            <?php } ?>



          </div>

        </div>
      </div>
    </div>
  </div>
</div><!-- /container -->

<?php get_footer(); ?>