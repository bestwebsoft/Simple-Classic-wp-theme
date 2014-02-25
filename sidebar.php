<?php
/**
 * The Sidebar containing the primary widget area.
 *
 * @subpackage Simple_Classic
 * @since Simple Classic
 */
?>

<div id="smplclssc_sidebar">
	<div class="smplclssc_widget">
		<ul>
			<?php if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( 'sidebar' ) ) : ?>
				<li><h2><?php _e( 'recent post', 'simpleclassic' ); ?></h2>
					<ul>
						<?php $result = wp_get_recent_posts( 
							array( 
								'numberposts' => 5,  
								'post_status' => 'publish' 
							) 
						);  
						foreach( $result as $p ) { ?>  
							<li><a href="<?php echo get_permalink( $p['ID'] ) ?>" ><?php echo $p['post_title'] ?></a></li>
						<?php } ?>
					</ul>
				</li>
				<li><h2><?php _e( 'recent comments', 'simpleclassic' ); ?></h2>
					<ul>
						<?php $comments = get_comments( 
							array( 
								'status' => 'approve',
								'number' => '3',
							) 
						);
						foreach( $comments as $comment ) : ?>
							<li><?php comment_author_link( $comment->comment_ID ) . ' ' . _e( 'on' , 'simpleclassic' ); ?> <a href="<?php echo get_comment_link( $comment->comment_ID ); ?>"><?php echo get_the_title( $comment->comment_post_ID ); ?></a></li>
						<?php endforeach; ?>
					</ul>
				</li>
				<li><h2><?php _e( 'archives', 'simpleclassic' ); ?></h2>
					<ul>
						<?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
					</ul>
				</li>
				<li><h2><?php _e( 'categories', 'simpleclassic' ); ?></h2>
					<ul>
						<?php wp_list_categories( 'title_li=' ); ?>
					</ul>
				</li>
				<li><h2><?php _e( 'meta', 'simpleclassic' ); ?></h2>
					<ul>
						<?php wp_register(); ?>
						<li><?php wp_loginout(); ?></li>
						<?php wp_meta(); ?>
					</ul>
				</li>
			<?php endif; ?>
		</ul>
	</div><!-- .widget -->
</div><!-- #sidebar -->
