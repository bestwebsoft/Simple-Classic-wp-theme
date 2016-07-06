<?php
/**
 * The Sidebar containing the primary widget area.
 *
 * @subpackage Simple_Classic
 * @since      Simple Classic
 */
?>

<div id="smplclssc_sidebar">
	<div class="smplclssc_widget">
		<ul>
			<?php if ( is_active_sidebar( 'sidebar-1' ) ) {
				dynamic_sidebar( 'sidebar-1' );
			} else { ?>
				<li><h2><?php _e( 'recent post', 'simple-classic' ); ?></h2>
					<ul>
						<?php $result = wp_get_recent_posts( array(
							'numberposts' => 5,
							'post_status' => 'publish',
						) );
						foreach ( $result as $p ) { ?>
							<li><a href="<?php echo get_permalink( $p['ID'] ) ?>"><?php echo $p['post_title'] ?></a></li>
						<?php } ?>
					</ul>
				</li>
				<li><h2><?php _e( 'recent comments', 'simple-classic' ); ?></h2>
					<ul>
						<?php $comments = get_comments( array(
							'status' => 'approve',
							'number' => '3',
						) );
						foreach ( $comments as $comment ) : ?>
							<li><?php echo get_comment_author_link( $comment->comment_ID ) . ' ' . __( 'on', 'simple-classic' ); ?>
								<a href="<?php echo get_comment_link( $comment->comment_ID ); ?>"><?php echo get_the_title( $comment->comment_post_ID ); ?></a>
							</li>
						<?php endforeach; ?>
					</ul>
				</li>
				<li><h2><?php _e( 'archives', 'simple-classic' ); ?></h2>
					<ul>
						<?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
					</ul>
				</li>
				<li><h2><?php _e( 'categories', 'simple-classic' ); ?></h2>
					<ul>
						<?php wp_list_categories( 'title_li=' ); ?>
					</ul>
				</li>
				<li><h2><?php _e( 'meta', 'simple-classic' ); ?></h2>
					<ul>
						<?php wp_register(); ?>
						<li><?php wp_loginout(); ?></li>
						<?php wp_meta(); ?>
					</ul>
				</li>
			<?php } ?>
		</ul>
	</div><!-- .widget -->
</div><!-- #sidebar -->
