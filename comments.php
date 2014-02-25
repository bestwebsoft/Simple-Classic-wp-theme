<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form.
	*
 * @subpackage Simple_Classic
 * @since Simple Classic
 */
?>

<div id="comments">
	<?php if ( post_password_required() ) : ?>
		<p><?php _e( 'This post is password protected. Enter the password to view any comments.', 'simpleclassic' ); ?></p>
	<?php
		/* Stop the rest of comments.php from being processed,
		 * but don't kill the script entirely -- we still have
		 * to fully load the template. */
		return;
	endif;
	/* You can start editing here -- including this comment! */
	if ( have_comments() ) : ?>
		<h3 id="comments-title">
			<?php printf( _n( __( 'One thought on', 'simpleclassic') . ' &ldquo;%2$s&rdquo;', '%1$s ' . __('thoughts on', 'simpleclassic' ) . ' &ldquo;%2$s&rdquo;', get_comments_number(), 'simpleclassic' ), 
			number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' ); ?>
		</h3>
		<ul class="commentlist"><?php wp_list_comments( array( 'callback' => 'simpleclassic_comment' ) ); ?></ul>
		<div class="navigation">
			<div class="alignleft"><?php previous_comments_link() ?></div>
			<div class="alignright"><?php next_comments_link() ?></div>
		</div><!-- .navigation -->
	<?php else : /* This is displayed if there are no comments so far */ 
		if ( comments_open() ) :
			/* If comments are open, but there are no comments. */
		else : /* Comments are closed */
		endif;
	endif;
	comment_form(); ?>
</div><!-- #comments -->
