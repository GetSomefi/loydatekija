<?php
/**
 * @package WordPress
 * Template Name: Ilmoitus kollaasi
 */
?>

<?php get_header(); ?>

<div id="ww">
    <div class="container">
      <main id="content">
          <header>
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
              <?php 
              $u = wp_get_current_user();
              if(in_array('opiskelija', $u->roles)):
              ?>
                <?php _e("Moikka","moikka"); ?> <?php echo wp_get_current_user()->user_login; ?>,<br />
                <?php _e("Alla näet uusimmat ilmoitukset työ- ja harjoittelupaikoista.","ohjeteksti-ilmoituksista"); ?>
              <?php endif; ?>
            </h3>
            <p>
              <?php echo _e("Tänään on","tanaan-on"); ?> <?php echo $date_now; ?>, <?php echo _e("viikko","viikko"); ?> <?php echo $week_now; ?>    
            </p>
            <?php
            endif;
            ?>
          </header>
          
          <section class="beat-branch-sort" aria-labelledby="beat-branch-sort-header">
            
            <div class="row">

              <div class="col-12">
                <h3 id="beat-branch-sort-header">Ilmoitusten suodatus</h3>
              </div>

              <div class="col-sm-12 col-md-5">
                <h4>Ala</h4>
                <button class="beat-sorter-branch beat-sorter-branch-tech" data-sort="Tekniikka">
                  <div class='beat-branch-type-icon branch-tech'>
                    <span><i class='fas fa-laptop'></i></span> Tekniikan alan ilmoitukset
                  </div>
                </button>
                <button class="beat-sorter-branch beat-sorter-branch-business" data-sort="Palveluliiketoiminta">
                  <div class='beat-branch-type-icon branch-business'>
                    <span><i class='fas fa-chart-line'></i></span> Palveluliiketoiminnan ilmoitukset
                  </div>
                </button>
                <button class="beat-sorter-branch beat-sorter-branch-medical" data-sort="Sosiaali- ja terveysala">
                  <div class='beat-branch-type-icon branch-medical'>
                    <span><i class='fa fa-heartbeat'></i></span> Sosiaali- ja terveysalan ilmoitukset
                  </div>
                </button>
                <button class="beat-sorter-branch beat-sorter-general beat-sorter-paid-only">
                  <div class='beat-salary-type-icon'>
                    <span><i class='fas fa-euro-sign'></i></span> Näytä vain palkalliset
                  </div>
                </button>
              </div>

              <div class="col-sm-12 col-md-4">
                <h4>Tyyppi</h4>
                <button class="beat-sorter-branch beat-sorter-general beat-sorter-noicon beat-sorter-summer" data-sort="">
                  <div class='beat-branch-type-icon branch-medical'>
                    Työ
                  </div>
                </button>
                <button class="beat-sorter-branch beat-sorter-general beat-sorter-noicon beat-sorter-internship">
                  <div class='beat-branch-type-icon branch-medical'>
                    Harjoittelu
                  </div>
                </button>
                <button class="beat-sorter-branch beat-sorter-general beat-sorter-noicon beat-sorter-project">
                  <div class='beat-branch-type-icon branch-medical'>
                    Projekti
                  </div>
                </button>
                <button class="beat-sorter-branch beat-sorter-general beat-sorter-noicon beat-sorter-thesis">
                  <div class='beat-branch-type-icon branch-medical'>
                    Opinnäytetyö
                  </div>
                </button>
              </div>

              <div class="hidden-until-sorted col-sm-12 col-md-3">
                <h4>Suodatus valinnat</h4>
                <button class="beat-sorter-branch beat-sorter-branch-clear" data-sort="clear-all">
                  <div class='beat-branch-type-icon'>
                    <span><i class="fas fa-eraser"></i></span> Tyhjennä
                  </div>
                </button>
              </div>

            </div>

          </section>

          <section aria-label="Sisältää kaikki avoimet haut" class="panel-group" id="all-jobs-list" role="tablist" aria-multiselectable="true">
            <div class="row announcements-holder">
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
                      //'value'  => date('Ymd', strtotime("-1 week")),
                      'value'  => date('Ymd', strtotime("-1 week")),
                      'compare'=> '>=',
                      'type'   => 'NUMERIC'
                  ))
          
              );
              $query = new WP_Query( $args );
              $i = 1; 
            ?>
            <?php 
              $col_sizes = "col-xs-12 col-sm-6 col-md-4"; //"col-xs-12 col-sm-6 col-md-6";
              if ( $query->have_posts() ) { 
            ?>
              <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                <?php $i++; ?>  
                <?php
                  $authorID = get_the_author_meta( 'ID' );
                  um_fetch_user( $authorID );
                  $user_name = get_the_author($authorID);

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
                <?php
                //print_r( get_field("ala_johon_ilmoitus_on_suunnattu") );

                $branches = implode(",",get_field("ala_johon_ilmoitus_on_suunnattu"));
                $data_attributes =    "data-workbranch='".$branches."' ";
                $data_attributes .=   "data-worktype='".get_field("tyon_tyyppi")."' ";

                if( in_array("Tekniikka", get_field("ala_johon_ilmoitus_on_suunnattu")) ){
                  $branches_technical = implode(",",get_field("tekniikan_kategoriat"));
                  $data_attributes .=   "data-worktype-technical='".$branches_technical."' ";
                }

                $data_attributes .= "aria-label='Ilmoituksen jättäjä ".$user_name.", Työn on " . get_field("palkkaus") . "' ";

                $salary_type_icon = "<div class='beat-salary-type-icon'>";
                $data_attributes .=   "data-salary-type='".get_field("palkkaus")."' ";
                if( get_field("palkkaus") == "Palkaton" ){
                  $salary_type_icon .= "<span class='beat-salary-type-unpayed'><i class='fas fa-euro-sign'></i></span>";
                }else{
                  $salary_type_icon .= "<span><i class='fas fa-euro-sign'></i></span>";
                }
                $salary_type_icon .= "</div>";
                ?>
                <?php
                
                $main_branch = "";
                $branch_type_icon = "";
                if( in_array("Tekniikka", get_field("ala_johon_ilmoitus_on_suunnattu")) ){
                $main_branch = "Tekniikka";
                $branch_type_icon .= "<div class='beat-branch-type-icon branch-tech'>";
                  $branch_type_icon .= "<span><i class='fas fa-laptop'></i></span>";
                $branch_type_icon .= "</div>";
                }
                if( in_array("Palveluliiketoiminta", get_field("ala_johon_ilmoitus_on_suunnattu")) ){
                $main_branch = "Palveluliiketoiminta";
                $branch_type_icon .= "<div class='beat-branch-type-icon branch-business'>";
                  $branch_type_icon .= "<span><i class='fas fa-chart-line'></i></span>";
                $branch_type_icon .= "</div>";
                }
                if( in_array("Sosiaali- ja terveysala", get_field("ala_johon_ilmoitus_on_suunnattu")) ){
                $main_branch = "Sosiaali- ja terveysala";
                $branch_type_icon .= "<div class='beat-branch-type-icon branch-medical'>";
                  $branch_type_icon .= "<span><i class='fa fa-heartbeat'></i></span>";
                $branch_type_icon .= "</div>";
                }
                
                ?>

                <div <?php echo $data_attributes; ?> class="one-announcement-button <?php echo $col_sizes; ?>">
                  <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="heading-<?php echo $i; ?>">
                      <div class="panel-title">
                        <?php echo $salary_type_icon . $branch_type_icon; ?>
                        <button data-sortable="<?php echo $main_branch; ?>" class="title-button one-announcement" role="button" data-toggle="collapse" data-parent="#announcements" href="#announcement-<?php echo $i; ?>" aria-expanded="true" aria-controls="announcement-<?php echo $i; ?>">
                          <div class="beat-company-info">
                            <?php
                            $avatar = um_get_avatar_uri( um_profile('profile_photo'), 120 );
        
                            echo "<div class='more-company-info' style='background-image:url(".$cover_uri.")'>";
                              echo "<div class='more-company-info-avatar'>";
                                echo "<div>";
                                  echo "<img src='" . $avatar . "'  alt='". $user_name ."'>";
                                echo "</div>";
                              echo "</div>";
                            echo "</div>";
                            ?>
                          </div>
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
                            <h5>Hakuaika päättyy tänään</h5>
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
                  </div>
                </div>
                <div id="announcement-<?php echo $i; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-<?php echo $i; ?>">
                  <button class="close-announcement" aria-label="<?php _e("Sulje avoin ilmoitus ikkuna"); ?>">
                    <i class="fas fa-times"></i>
                  </button>
                  <div class="panel-body">
                    <div class="panel-link">
                      <a title="<?php _e("Lue koko ilmoitus"); ?>" href="<?php the_permalink(); ?>">
                        <?php _e("Lue koko ilmoitus"); ?>
                      </a>
                    </div>
                    <?php the_content(); ?>

                    <?php if( get_field('piilota_yhteystiedot_') == "no" ): ?>
                    <div>
                      <h3>Yhteys</h3>
                      <?php
                      if( get_field('nimi') == "" ){
                      echo um_user('first_name') . " " . um_user('last_name') . "<br />";
                      }else{
                        echo get_field('nimi') . "<br />";
                        
                      }

                      if( get_field('sahkoposti') == "" ){
                        echo um_user('user_email') . "<br />";
                      }else{
                        echo get_field('sahkoposti') . "<br />";
                      }

                      if( get_field('puhelin') == "" ){
                        echo um_user('phone_number');
                      }else{
                        echo get_field('puhelin');
                      }
                      ?>
                    </div>
                    <?php endif; ?>

                    <div class="panel-link">
                      <a title="<?php _e("Lue koko ilmoitus"); ?>" href="<?php the_permalink(); ?>">
                        <?php _e("Lue koko ilmoitus"); ?>
                      </a>
                    </div>
                  </div>
                </div>


              <?php endwhile; wp_reset_postdata(); ?>
            <?php } ?>


           
          </div>
      </section>

      <section>
        <h1>ILMAVA<br />BANNERI</h1>
      </section>

    </main>
  </div>
</div><!-- /container -->

<?php get_footer(); ?>