<?php 
/**
 * The Template for displaying all single posts.
 *
 * @subpackage Simple_Classic
 * @since Simple Classic
 */

get_header(); ?>
	<div id="smplclssc_content">
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<?php if( have_posts() ) :
				while( have_posts() ) : the_post(); ?>
					<div id="nav-single">
						<span class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">&larr;</span> ' . __( 'Previous', 'simpleclassic' ) ); ?></span>
						<span class="nav-next"><?php next_post_link( '%link', __( 'Next', 'simpleclassic' ) . ' <span class="meta-nav">&rarr;</span>' ); ?></span>
					</div><!-- #nav-single -->
					<h1 class="smplclssc_titleinmain"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
					<p class="smplclssc_data-descr">
						<?php _e( 'Posted on', 'simpleclassic' ); ?> <a href="<?php the_permalink(); ?>"><?php the_date(); ?></a> 
						<?php _e( 'in', 'simpleclassic' ); ?> <a href="<?php the_permalink(); ?>"><?php the_category( ' ' ); ?></a>
					</p><!-- .smplclssc_data-descr -->
					<p><?php the_content(); ?></p>
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
						); ?>
					</div>
					<?php if ( comments_open( get_the_ID() ) ) : 
						comments_template( '', true );
					endif;
				endwhile;
			endif; ?>
		</div><!-- #post-## -->
	</div><!-- #smplclssc_content -->
<?php get_sidebar();
get_footer(); ?>
