<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content
 * after.  Calls sidebar-footer.php for bottom widgets.
 *
 * @subpackage Simple_Classic
 * @since Simple Classic
 */
?>
		</div><!-- #smplclssc_main -->
		<div id="smplclssc_footer">
			<div id="smplclssc_footer-content">
				<p class="smplclssc_copirate"><?php _e( 'Copyright', 'simpleclassic'); ?> &#169; <a href="<?php echo home_url(); ?>"><?php bloginfo( 'name' ); ?></a> <?php echo date('Y'); ?></p>
				<p class="smplclssc_footerlinks"><?php _e( 'Powered by', 'simpleclassic' ); ?> <a href="<?php echo esc_url( 'https://github.com/bestwebsoft' ); ?>" target="_blank"><?php printf( 'BestWebSoft team' ); ?></a> <?php _e( 'and', 'simpleclassic' ); ?> <a href="http://www.wordpress.org" target="_blank"><?php _e( 'WordPress', 'simpleclassic' ); ?></a></p>
			</div><!-- #smplclssc_footer-content -->
		</div><!-- #smplclssc_footer -->
	</div><!-- #smplclssc_main-container -->
	<?php wp_footer(); ?>
</body>
</html>
