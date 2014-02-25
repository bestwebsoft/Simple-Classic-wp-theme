<?php 
/**
 * The template used to display Tag Archive pages
 *
 * @subpackage Simple_Classic
 * @since Simple Classic
 */

get_header(); ?>
	<div id="smplclssc_content">
		<?php $count = 0; /* Post counter */
		if ( have_posts() ) : ?>
			<h1 class="smplclssc_page-title">
				<?php printf( __( 'Tag Archives:', 'simplaclassic' ) . ' %s', '<span>' . single_tag_title( '', false ) . '</span>' ); ?>
			</h1>
			<?php $tag_description = tag_description();
						if ( ! empty( $tag_description ) )
							echo apply_filters( 'tag_archive_meta', '<div class="tag-archive-meta">' . $tag_description . '</div>' );
			while ( have_posts() ) : the_post(); ?>
				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<h1 class="smplclssc_titleinmain"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
					<p class="smplclssc_data-descr"><?php _e( 'Posted on', 'simpleclassic' ); ?> <a href="<?php the_permalink(); ?>"><?php the_date(); ?></a> 
						<?php _e( 'in', 'simpleclassic' ); ?> <?php the_category( ' ' ); ?>
					</p>		
					<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
					<?php $attachment = get_posts( 
						array( 
							'post_type'   => 'attachment',
							'post_parent' => $post->ID
						) 
					);
					if ( $attachment ) {
						echo '<p class="smplclssc_img-descr">' . $attachment[0]->post_excerpt . '</p>';
					} ?>
					<p><?php the_excerpt(); ?></p>
					<?php if( has_tag() ) : ?>
						<div class="smplclssc_tags">
							<p><?php the_tags(); ?></p>
						</div>
					<?php endif; ?>
					<div class="smplclssc_post-border">
						<?php wp_link_pages( 
							array( 
								'before' => '<div class="smplclssc_page-links"><span>'.__( 'Pages: ', 'simpleclassic' ).'</span>',
								'after'  => '</div>'
							) 
						); 
						if( $count > 1 ) : ?>
							<a class="smplclssc_links" href="#">[<?php _e( 'Top', 'simpleclassic' ); ?>]</a>
						<?php endif; ?>
					</div><!-- .post-border -->
					<?php $count++; /* Posts counter */?>
				</div><!-- #post-## -->
			<?php endwhile; 
		else : ?>
			<h3 class="smplclssc_page-title"><?php _e( 'Nothing Found', 'simpleclassic' ) ?></h3>
			<div class="smplclssc_entry-content">
				<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'simpleclassic' ); ?></p>
				<?php get_search_form(); ?>
			</div><!-- .smplclssc_entry-content -->
		<?php endif;
		simpleclassic_content_nav( 'nav-below' ); ?>
	</div><!-- #smplclssc_content -->
<?php get_sidebar();
get_footer(); ?>
