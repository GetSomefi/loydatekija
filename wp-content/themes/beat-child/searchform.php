<?php
/**
 * Custom search form
 */
?>
<form action="<?php echo home_url( '/' ); ?>" method="get">
    <input type="text" name="s" id="search" placeholder="<?php _e('Kirjoita hakusana') ?>" value="<?php the_search_query(); ?>" />
    <input type="submit" class="search-submit"
        value="<?php echo esc_attr_x( 'Hae', 'Submit-button-hae' ) ?>" />
</form>