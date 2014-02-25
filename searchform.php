<?php
/**
 * The template for displaying search forms in SimpleClassic
 *
 * @subpackage Simple_Classic
 * @since Simple Classic
 */
?>

<form id="smplclssc_search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get">
	<div><input class="smplclssc_search-txt" type="text" name="s" id="s" value="<?php _e( 'Enter search keyword', 'simplaclassic' ); ?>" onfocus="if ( this.value == '<?php _e( 'Enter search keyword', 'simplaclassic' ); ?>' ) { this.value = ''; }" onblur="if ( this.value == '' ) { this.value = '<?php _e( 'Enter search keyword', 'simplaclassic'); ?>'; }" /></div>
	<div><input class="smplclssc_search-btn" type="submit" value="<?php _e( 'search', 'simplaclassic' ); ?>" /></div>
</form>
