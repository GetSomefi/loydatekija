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
        remove_menu_page( 'profile.php' );//Profile
    }
    add_action( 'admin_menu', 'remove_menus' );

    // example custom dashboard widget
    function custom_dashboard_widget() {
        $u = wp_get_current_user();
        if(in_array('opiskelija', $u->roles)){
            echo "<p>" . __e("Selaa avoimia uramahdollisuuksia täältä") . "</p>";
        }else if(in_array('asiakas', $u->roles)){
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

?>