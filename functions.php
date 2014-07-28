<?php 
/**
 * Simple Classic functions and definitions
 *
 * Sets up the theme and provides some helper functions. Some helper functions
 * are used in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * The first function, simpleclassic_setup(), sets up the theme by registering support
 * for various features in WordPress, such as post thumbnails, navigation menus, and the like.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development and
 * http://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are instead attached
 * to a filter or action hook. The hook can be removed by using remove_action() or
 * remove_filter() and you can attach your own function to the hook.
 *
 * We can remove the parent theme's hook only after it is attached, which means we need to
 * wait until setting up the child theme:
 *
 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
 *
 * @subpackage Simple_Classic
 * @since Simple Classic
 */

if ( ! isset( $content_width ) )
	$content_width = 625;
add_theme_support( 'content-width', $content_width );

/*Function Simple Classic Setup*/
function simpleclassic_setup() {
	/* This theme styles the visual editor with editor-style.css to match the theme style. */
	add_editor_style();
	/* This theme uses post thumbnails */
	add_theme_support( 'post-thumbnails' );
	/* Set size of thumbnails */
	set_post_thumbnail_size( 540, 283, true );
	/* Add default posts and comments RSS feed links to head */
	add_theme_support( 'automatic-feed-links' );
	load_theme_textdomain( 'simpleclassic', get_template_directory() . '/languages' );
	/* Register Simple Classic menu */
	register_nav_menu( 'primary',__( 'Header Menu', 'simpleclassic' ) );
	/* Sidebar register */
	if ( function_exists( 'register_sidebar' ) )
		register_sidebar( array( 'name' => __( 'Sidebar', 'simpleclassic' ) ) ); 
	/* Add support for custom headers. */
	$custom_header_support = array(
		/* The default header text color. */
		'default-text-color' => '000',
		/* The height and width of our custom header. */
		'width' => apply_filters( 'simpleclassic_header_image_width', 960 ),
		'height' => apply_filters( 'simpleclassic_header_image_height', 283 ),
		/* Support flexible heights. */
		'flex-height' => true,
		/* Random image rotation by default. */
		'random-default' => true,
		/* Callback for styling the header. */
		'wp-head-callback' => 'simpleclassic_header_style',
		/* Callback for styling the header preview in the admin. */
		'admin-head-callback' => 'simpleclassic_admin_header_style',
		/* Callback used to display the header preview in the admin. */
		'admin-preview-callback' => 'simpleclassic_admin_header_image',
	);	
	add_theme_support( 'custom-header', $custom_header_support );
	add_theme_support( 'custom-background' );
	/* Add a way for the custom background to be styled in the admin panel that controls
	 * custom headers.
	 * We'll be using post thumbnails for custom header images on posts and pages.
	 * We want them to be the size of the header image that we just defined
	 * Larger images will be auto-cropped to fit, smaller ones will be ignored. See header.php. */
	set_post_thumbnail_size( $custom_header_support['width'], $custom_header_support['height'], true );
	/* Add Simple Classic's custom image sizes. 
	 * Used for large feature (header) images. */
	add_image_size( 'large-feature', $custom_header_support['width'], $custom_header_support['height'], true );
	/* Used for featured posts if a large-feature doesn't exist. */
	add_image_size( 'small-feature', 500, 300 ); 
} /* Simpleclassic_setup */

/* Displaying title */
function simpleclassic_filter_wp_title( $title, $sep ){
	global $paged, $page;

	if ( is_feed() )
		return $title;

	/* Add the site name. */
	$title .= get_bloginfo( 'name' );

	/* Add the site description for the home/front page. */
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	/* Add a page number if necessary. */
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page', 'simpleclassic' ) . ' %s', max( $paged, $page ) );

	return $title;
}  

/* Styles the header image and text displayed on the blog */
function simpleclassic_header_style() {
	$text_color = get_header_textcolor();
	/* If no custom options for text are set, let's bail. */
	if ( $text_color == HEADER_TEXTCOLOR )
		return;
	/* If we get this far, we have custom styles. Let's do this. */?>
	<style type="text/css">
	<?php /* Has the text been hidden? */
		if ( 'blank' == $text_color ) : ?>
		#smplclssc_site-title,
		#smplclssc_site-description {
			position: absolute !important;
			clip: rect(1px 1px 1px 1px); /* IE6, IE7 */
			clip: rect(1px, 1px, 1px, 1px);
		}
	<?php /* If the user has set a custom color for the text use that */
		else : ?>
		#smplclssc_site-title a,
		#smplclssc_site-description {
			color: #<?php echo $text_color; ?> !important;
		}
	<?php endif; ?>
	</style>
	<?php
} /* simpleclassic_header_style */

/* Styles the header image displayed on the Appearance > Header admin panel.
 * 
 * Referenced via add_theme_support('custom-header') in simpleclassic_setup(). */
function simpleclassic_admin_header_style() { ?>
	<style type="text/css">
	.appearance_page_custom-header #headimg {
		border: none;
	}
	#headimg h1,
	#desc {
		font-family: open_sansregular, "Helvetica Neue", Arial, Helvetica, "Nimbus Sans L", sans-serif;
	}
	#headimg h1 {
		margin: 0;
	}
	#headimg h1 a {
		font-size: 32px;
		line-height: 36px;
		text-decoration: none;
	}
	#desc {
		font-size: 14px;
		line-height: 23px;
		padding: 0 0 3em;
	}
	<?php /* If the user has set a custom color for the text use that */
		if ( get_header_textcolor() != HEADER_TEXTCOLOR ) : ?>
		#site-title a,
		#site-description {
			color: #<?php echo get_header_textcolor(); ?>;
		}
	<?php endif; ?>
	#headimg img {
		max-width: 960px;
		height: 283;
		width: 100%;
	}
	</style>
<?php
} /* simpleclassic_admin_header_style */

/* Custom header image markup displayed on the Appearance > Header admin panel.
 *
 * Referenced via add_theme_support('custom-header') in simpleclassic_setup(). */
function simpleclassic_admin_header_image() { ?>
	<div id="headimg">
		<?php $color = get_header_textcolor();
		$image = get_header_image();
		if ( $color && $color != 'blank' )
			$style = ' style="color:#' . $color . '"';
		else $style = ' style="display:none"'; ?>
		<h1><a id="name"<?php echo $style; ?> onclick="return false;" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
		<div id="desc"<?php echo $style; ?>><?php bloginfo( 'description' ); ?></div>
		<?php if ( $image ) : ?>
			<img src="<?php echo esc_url( $image ); ?>" alt="" />
		<?php endif; ?>
	</div>
<?php } /* simpleclassic_admin_header_image */

/* Function that connects scripts for theme */
function simpleclassic_script() {
		wp_enqueue_script( 'jquery' ); ?>
		<script type="text/javascript">
				var search='<?php echo __( 'Search ...','simpleclassic' ); ?>';
				var url = theme_url = '<?php echo get_stylesheet_directory_uri(); ?>';
		</script>
		<?php wp_enqueue_script( 'simpleclassic-main-script', get_stylesheet_directory_uri().'/js/script.js' ); 
		wp_enqueue_script( 'comment-reply' );
		wp_enqueue_style( 'simpleclassic-style', get_stylesheet_uri() ); 
		wp_register_style( 'simpleclassic-style-ie', get_stylesheet_directory_uri() . '/css/ie.css' );
		$GLOBALS['wp_styles']->add_data( 'simpleclassic-style-ie', 'conditional', 'IE' );
		wp_enqueue_style( 'simpleclassic-style-ie' );
}

/* Display navigation to next/previous pages when applicable */
function simpleclassic_content_nav( $html_id ) {
	global $wp_query;
	if ( $wp_query->max_num_pages > 1 ) : ?>
		<nav id="<?php echo esc_attr( $html_id ); ?>">
			<div class="nav-previous"><?php next_posts_link( '<span class="meta-nav">&larr;</span> ' . __( 'Older posts', 'simpleclassic' ) ); ?></div>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts', 'simpleclassic' ) . ' <span class="meta-nav">&rarr;</span>' ); ?></div>
		</nav><!-- #nav-above -->
	<?php endif;
}

/* Styles the header image displayed on the Appearance > Header admin panel.
 *
 * Referenced via custom-header hook in simpleclassic_setup(). */
function simpleclassic_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
		switch ( $comment->comment_type ) :
			case 'pingback'  :
			case 'trackback' : ?>
				<li class="post pingback">
					<p><?php _e( 'Pingback:', 'simpleclassic' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( 'Edit', 'simpleclassic' ), ' ' ); ?></p>
				<?php break;
			default : ?>
				<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>" >
					<div id="comment-<?php comment_ID(); ?>" >
						<div class="comment-author vcard" >
							<?php echo get_avatar( $comment, 64 ); ?>
							<?php printf( '%s <span class="says">' . __( 'says:', 'simpleclassic' ) . '</span>', sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
						</div><!-- .comment-author .vcard -->
						<?php if ( $comment->comment_approved == '0' ) : ?>
							<em class="comment-awaiting-moderation" ><?php _e( 'Your comment is awaiting moderation.', 'simpleclassic' ); ?></em>
							<br />
						<?php endif; ?>
						<div class="comment-meta commentmetadata"><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>" >
							<?php /* translators: 1: date, 2: time */
							printf( '%1$s ' . __( 'at', 'simpleclassic' ) . ' %2$s', get_comment_date(),  get_comment_time() ); ?></a>
						</div><!-- .comment-meta .commentmetadata -->
						<div class="comment-body"><?php comment_text(); ?></div>
						<div class="reply">
							<p><?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); edit_comment_link( __( 'Edit', 'simpleclassic' ), ' ' ); ?></p>
						</div><!-- .reply -->
					</div><!-- #comment-##  -->
			<?php break;
		endswitch;
}

/* Making navigation */
function simpleclassic_navigation() {
	global $post;
	/* Options */
	$text['home']     = __( 'Home', 'simpleclassic' ); /* Link text "Home" */
	$text['category'] = __( 'Category:', 'simpleclassic' ) . ' %s'; /* Text for a category page */
	$text['search']   = __( 'Results for:', 'simpleclassic' ) . ' %s'; /* Text for the search results page */
	$text['tag']      = __( 'Tags:', 'simpleclassic' ) . ' %s'; /* Text for the tag page */
	$text['author']   = __( 'Autors posts:', 'simpleclassic' ) . ' %s'; /* Text for the autor page */
	$text['404']      = __( 'Error 404', 'simpleclassic' ); /* Text for the page 404 */
	$showCurrent = 1; /* 1 - show the name of the current article / page, 0 - no */
	$showOnHome  = 0; /* 1 - show the "simpleclassic_navigation" on the main page, 0 - no */
	$delimiter   = ' - '; /* Divide between the "simpleclassic_navigation" */
	$before      = '<span>'; /* Tag before the current "crumb" */
	$after       = '</span>'; /* Tag after the current "crumb" */
	/* End options */
	$homeLink   = home_url() . '/';
	$linkBefore = '<span">';
	$linkAfter  = '</span>';
	$linkAttr   = ' rel=""';
	$link       = $linkBefore . '<a' . $linkAttr . ' href="%1$s">%2$s</a>' . $linkAfter;
 
	if ( is_home() || is_front_page() ) {
		if ( $showOnHome == 1 ) 
			echo '<h2 id="smplclssc_crumbs"><a href="' . $homeLink . '">' . $text['home'] . '</a></h2>';
	} elseif( is_page() ) {
		
			echo '<h1>';
				echo '<a href="';
					the_permalink();
					echo '">';
					echo get_the_title();
				echo '</a>';
			echo '</h1>';
		
	} else {
		echo '<h2 id="smplclssc_crumbs">' . sprintf( $link, $homeLink, $text['home'] ) . $delimiter;
		if ( is_category() ) {
			$thisCat = get_category( get_query_var( 'cat' ), false );
			if ( $thisCat->parent != 0 ) {
				$cats = get_category_parents( $thisCat->parent, true, $delimiter );
				$cats = str_replace( '<a', $linkBefore . '<a' . $linkAttr, $cats );
				$cats = str_replace( '</a>', '</a>' . $linkAfter, $cats );
				echo $cats;
			}
			echo $before . sprintf( $text['category'], single_cat_title('', false) ) . $after;
		} elseif ( is_search() ) {
			echo $before . sprintf( $text['search'], get_search_query() ) . $after;
		} elseif ( is_day() ) {
			echo sprintf( $link, get_year_link(get_the_time( 'Y' ) ), get_the_time( 'Y' ) ) . $delimiter;
			echo sprintf( $link, get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ), get_the_time( 'F' ) ) . $delimiter;
			echo $before . get_the_time( 'd' ) . $after;
		} elseif ( is_month() ) {
			echo sprintf( $link, get_year_link( get_the_time( 'Y' ) ), get_the_time( 'Y' ) ) . $delimiter;
			echo $before . get_the_time( 'F' ) . $after;
		} elseif ( is_year() ) {
			echo $before . get_the_time( 'Y' ) . $after;
		} elseif ( is_single() && !is_attachment() ) {
			if ( get_post_type() != 'post' ) {
				$post_type = get_post_type_object( get_post_type() );
				$slug = $post_type->rewrite;
				printf( $link, $homeLink . '/' . $slug['slug'] . '/', $post_type->labels->singular_name );
				if ( $showCurrent == 1 ) echo $delimiter . $before . get_the_title() . $after;
			} else {
				$cat  = get_the_category(); $cat = $cat[0];
				$cats = get_category_parents( $cat, true, $delimiter );
				if ( $showCurrent == 0 ) $cats = preg_replace( "#^(.+)$delimiter$#", "$1", $cats );
				$cats = str_replace( '<a', $linkBefore . '<a' . $linkAttr, $cats );
				$cats = str_replace( '</a>', '</a>' . $linkAfter, $cats );
				echo $cats;
				if ( $showCurrent == 1 ) echo $before . get_the_title() . $after;
			}
		} elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
			$post_type = get_post_type_object( get_post_type() );
			echo $before . $post_type->labels->singular_name . $after;
		} elseif ( is_attachment() ) {
			$parent = get_post( $post->post_parent );
			$cat    = get_the_category( $parent->ID ); $cat = $cat[0];
			$cats   = get_category_parents( $cat, true, $delimiter );
			$cats   = str_replace( '<a', $linkBefore . '<a' . $linkAttr, $cats );
			$cats   = str_replace( '</a>', '</a>' . $linkAfter, $cats );
			echo $cats;
			printf( $link, get_permalink( $parent ), $parent->post_title );
			if ( $showCurrent == 1 ) echo $delimiter . $before . get_the_title() . $after;
		} elseif ( is_page() && !$post->post_parent ) {
			if ( $showCurrent == 1 ) 
				echo $before . get_the_title() . $after;
		} elseif ( is_page() && $post->post_parent ) {
			$parent_id  = $post->post_parent;
			$breadcrumbs = array();
			while ( $parent_id ) {
				$page = get_page( $parent_id );
				$breadcrumbs[] = sprintf( $link, get_permalink( $page->ID ), get_the_title( $page->ID ) );
				$parent_id  = $page->post_parent;
			}
			$breadcrumbs = array_reverse( $breadcrumbs );
			for ( $i = 0; $i < count( $breadcrumbs ); $i++ ) {
				echo $breadcrumbs[$i];
				if ( $i != count( $breadcrumbs ) -1 ) 
					echo $delimiter;
			}
			if ( $showCurrent == 1 ) 
				echo $delimiter . $before . get_the_title() . $after;
		} elseif ( is_tag() ) {
			echo $before . sprintf( $text['tag'], single_tag_title( '', false ) ) . $after;
		} elseif ( is_author() ) {
			global $author;
			$userdata = get_userdata( $author );
			echo $before . sprintf( $text['author'], $userdata->display_name ) . $after;
		} elseif ( is_404() ) {
			echo $before . $text['404'] . $after;
		}
		if ( get_query_var( 'paged' ) ) {
			if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) 
				echo ' (';
			echo __( 'Page', 'simpleclassic' ) . ' ' . get_query_var( 'paged' );
			if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) 
				echo ')';
		}
		echo '</h2>';
	}
} /* End of simpleclassic_navigation() */

add_action( 'after_setup_theme', 'simpleclassic_setup' );
add_filter( 'wp_title', 'simpleclassic_filter_wp_title', 10, 3 );
add_action( 'wp_enqueue_scripts', 'simpleclassic_script' );
add_filter( 'simpleclassic_navigation', 'simpleclassic_navigation' );
add_filter( 'simpleclassic_content_nav', 'simpleclassic_content_nav' );
