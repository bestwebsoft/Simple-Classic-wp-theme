<?php 
/**
 * The template for displaying Search Results pages.
 *
 * @subpackage Simple_Classic
 * @since Simple Classic
 */

get_header(); ?>
	<div id="smplclssc_content">
		<h1 class="smplclssc_page-title"><?php printf( __( 'Search Results for:', 'simpleclassic' ) . ' %s', get_search_query() ); ?></h1>
		<?php $count = 0;
		if( have_posts() ) : 
			while( have_posts() ) : the_post(); ?>
				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<h1 class="smplclssc_titleinmain"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
					<p class="smplclssc_data-descr">
						<?php _e( 'Posted on', 'simpleclassic' ); ?> <a href="<?php the_permalink(); ?>"><?php the_date(); ?></a> 
						<?php _e( 'in', 'simpleclassic' ); ?> <a href="<?php the_permalink(); ?>"><?php the_category( ' ' ); ?></a>
					</p><!-- .smplclssc_data-descr -->
					<?php the_content();
					if( has_tag() ) : ?>
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
						); ?>
						<?php if( $count > 1 ) : ?>
						<a class="smplclssc_links" href="#">[<?php _e( 'Top', 'simpleclassic' ); ?>]</a>
						<?php endif; ?>
					</div>
					<?php $count++; ?>
				</div><!-- #post-## -->
			<?php endwhile; 
		else : ?>
			<h3 class="smplclssc_titleinmain"><?php printf( __( 'On request, no results!', 'simpleclassic' ), get_search_query() ); ?></h3>
		<?php endif; 
		simpleclassic_content_nav( 'nav-below' ); ?>
	</div>
<?php get_sidebar();
get_footer(); ?>
