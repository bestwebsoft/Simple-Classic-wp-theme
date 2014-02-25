<?php 
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 * @subpackage Simple_Classic
 * @since Simple Classic
 */

get_header(); ?>
	<div id="smplclssc_content">
		<?php $count = 0; /* Post counter */
		if ( have_posts() ) : ?>
			<h1 class="smplclssc_page-title">
				<?php if ( is_day() ) : 
					printf( __( 'Daily Archives:', 'simpleclassic' ) . ' %s', '<span>' . get_the_date() . '</span>' );
				elseif ( is_month() ) :
					printf( __( 'Monthly Archives:', 'simpleclassic' ) . ' %s', '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'simpleclassic' ) ) . '</span>' );
				elseif ( is_year() ) : 
					printf( __( 'Yearly Archives:', 'simpleclassic' ) . ' %s', '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'simpleclassic' ) ) . '</span>' );
				else : 
					_e( 'Blog Archives', 'simpleclassic' );
				endif; ?>
			</h1>
			<?php /* Start the Loop */
			while ( have_posts() ) : the_post(); ?>
				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<h1 class="smplclssc_titleinmain"><a href="<?php the_permalink(); ?>"><?php the_title(); /* Post title */ ?></a></h1> 
					<p class="smplclssc_data-descr">
						<?php _e( 'Posted on', 'simpleclassic' ); ?> <a href="<?php the_permalink(); ?>"><?php the_date(); ?></a> 
						<?php _e( 'in', 'simpleclassic' ); ?> <?php the_category( ' ' ); ?>
					</p><!-- .smplclssc_data-descr -->
					<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
					<p><?php the_excerpt(); /* Excerpt of post */ ?></p>
					<?php if( has_tag() ) : ?>
						<div class="smplclssc_tags">
							<p><?php the_tags(); ?></p>
						</div>
					<?php endif; ?>
					<div class="smplclssc_post-border">
						<?php wp_link_pages( 
							array( 
								'before' => '<div class="smplclssc_page-links"><span>' . __( 'Pages:', 'simpleclassic' ) . ' </span>',
								'after'  => '</div>'
							) 
						); ?>
						<?php if( $count > 1 ) : ?>
							<a class="smplclssc_links" href="#"><?php _e( 'Top', 'simpleclassic' ); ?></a>
						<?php endif; ?>
					</div><!-- .smplclssc_post-border -->
					<?php $count++; /* Post counter */ ?>
				</div><!-- #post-## -->
			<?php endwhile;
		else : ?>
			<h3 class="smplclssc_page-title"><?php _e( 'Nothing Found', 'simpleclassic' ); ?></h3>
			<div class="smplclssc_entry-content">
				<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'simpleclassic' ); ?></p>
				<?php get_search_form(); ?>
			</div><!-- .smplclssc_entry-content -->
		<?php endif; 	
		simpleclassic_content_nav( 'nav-below' ); ?>
	</div><!-- #smplclssc_content -->
<?php get_sidebar();
get_footer(); ?>
