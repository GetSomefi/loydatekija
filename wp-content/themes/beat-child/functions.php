<?php
function loydatekija_enqueue_styles() {

    $parent_style = 'wp-bootstrap-starter'; // This is 'twentyfifteen-style' for the Twenty Fifteen theme.

    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css?v=20181104',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );

    wp_enqueue_script('jquery');
    wp_enqueue_script('themes-main-script', get_stylesheet_directory_uri() . '/script.js', array() );
}
add_action( 'wp_enqueue_scripts', 'loydatekija_enqueue_styles' );

function posts_for_current_author($query) {
    global $pagenow;
 
    if( 'edit.php' != $pagenow || !$query->is_admin )
        return $query;
 
    if( !current_user_can( 'edit_others_posts' ) ) {
        global $user_ID;
        $query->set('author', $user_ID );
    }
    return $query;
}
add_filter('pre_get_posts', 'posts_for_current_author');


//wp-admin näkymä opiskelijalle ja yrittäjälle simppelimmäksi
$user = wp_get_current_user();
$allowed_roles = array('opiskelija','asiakas');
if( array_intersect($allowed_roles, $user->roles ) ) { 
    function remove_menus(){
        remove_menu_page( 'edit.php' ); //Posts
        remove_menu_page( 'upload.php' );//Media
        remove_menu_page( 'link-manager.php' );//Links
        remove_menu_page( 'edit-comments.php' );//Comments
        remove_menu_page( 'edit.php?post_type=project' ); //Projects
        remove_menu_page( 'tools.php' );//Tools
        remove_menu_page( 'index.php' );//Dashboard
        //remove_menu_page( 'profile.php' );//Profile
    }
    add_action( 'admin_menu', 'remove_menus' );

    // example custom dashboard widget
    function custom_dashboard_widget() {
        $u = wp_get_current_user();
        if(in_array('opiskelija', $u->roles)){
            echo "<p>" . __e("Selaa avoimia uramahdollisuuksia täältä") . "</p>";
        }else if(in_array('asiakas', $u->roles)){
            echo "<p><a href='" . get_home_url() . "/wp-admin/profile.php'>Muokkaa profiilia</a></p>";
            echo "<p><a href='" . get_home_url() . "/wp-admin/post-new.php?post_type=asiakaspuoli'>Jätä uusi ilmoitus painamalla tästä</a></p>";
        } 
    }
    function add_custom_dashboard_widget() {
        wp_add_dashboard_widget('custom_dashboard_widget', 'Tervetuloa!', 'custom_dashboard_widget');
    }
    add_action('wp_dashboard_setup', 'add_custom_dashboard_widget');

    // disable default dashboard widgets
    function disable_default_dashboard_widgets() {

        remove_meta_box('dashboard_right_now', 'dashboard', 'core');
        remove_meta_box('dashboard_activity', 'dashboard', 'core');
        
        remove_meta_box('dashboard_recent_comments', 'dashboard', 'core');
        remove_meta_box('dashboard_incoming_links', 'dashboard', 'core');
        remove_meta_box('dashboard_plugins', 'dashboard', 'core');

        remove_meta_box('dashboard_quick_press', 'dashboard', 'core');
        remove_meta_box('dashboard_recent_drafts', 'dashboard', 'core');
        remove_meta_box('dashboard_primary', 'dashboard', 'core');
        remove_meta_box('dashboard_secondary', 'dashboard', 'core');
        
    }
    add_action('admin_menu', 'disable_default_dashboard_widgets');
}

/*extra fields for profile*/
add_action( 'show_user_profile', 'yoursite_extra_user_profile_fields' );
add_action( 'edit_user_profile', 'yoursite_extra_user_profile_fields' );
function yoursite_extra_user_profile_fields( $user ) {
?>

    <table id="beat-extra-fields" class="form-table">
        <tbody>
            <tr>
                <th>
                    <label for="phone"><?php _e("Phone"); ?></label>
                </th>
                <td>
                    <input type="text" name="phone" id="phone" class="regular-text" value="<?php echo esc_attr( get_the_author_meta( 'phone', $user->ID ) ); ?>" />
                </td>
            </tr>
            <tr>
                <th>
                    <label for="homeaddress"><?php _e("Address"); ?></label>
                </th>
                <td>
                    <input type="text" name="homeaddress" id="homeaddress" class="regular-text" value="<?php echo esc_attr( get_the_author_meta( 'homeaddress', $user->ID ) ); ?>" />
                </td>
            </tr>
        </tbody>
    </table>

<?php
}

add_action( 'personal_options_update', 'yoursite_save_extra_user_profile_fields' );
add_action( 'edit_user_profile_update', 'yoursite_save_extra_user_profile_fields' );
function yoursite_save_extra_user_profile_fields( $user_id ) {
  $saved = false;
  if ( current_user_can( 'edit_user', $user_id ) ) {
    update_user_meta( $user_id, 'phone', $_POST['phone'] );
    update_user_meta( $user_id, 'homeaddress', $_POST['homeaddress'] );
    $saved = true;
  }
  return true;
}

function wpse39285_field_placement_js() {
    $screen = get_current_screen();
    if ( $screen->id != "profile" && $screen->id != "user-edit" ) 
        return;
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            //hide default fields
            $('.user-url-wrap, .user-rich-editing-wrap, .user-syntax-highlighting-wrap, .user-admin-color-wrap, .user-comment-shortcuts-wrap, .user-admin-bar-front-wrap').hide();

            field = $('#beat-extra-fields').remove();
            field.insertAfter( $('.user-email-wrap').closest('.form-table') );
        });
    </script>
    <?php
}
add_action( 'admin_head', 'wpse39285_field_placement_js' );

add_filter('wp_nav_menu_items', 'add_login_logout_link', 10, 2);
function add_login_logout_link($items, $args) {
    if( !is_user_logged_in() ){
        $items .= '<li class="login-logout"><a title="'.__('Kirjaudu','kirjaudu').'" href="'.get_site_url().'/wp-login.php"><i class="fas fa-sign-in-alt"></i></a></li>';
    }
    return $items;
}

function cust_login_logo() { ?>
    <style type="text/css">
        #login h1 a, .login h1 a {
            background-image: url(http://localhost/LoydaOsaaja/wp-content/themes/beat-child/img/samk_logo_musta.png);
            height: 100px;
            width: 320px;
            background-size: auto 100%;
            background-repeat: no-repeat;
            padding-bottom: 30px;
            background-position: center;
        }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'cust_login_logo' );
?>