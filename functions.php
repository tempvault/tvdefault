<?php
/**
 * Functions and definitions for our theme
 *
 */

/**
 * Set the content width.
 */
if ( ! isset( $content_width ) )
	$content_width = 640; /* pixels */

/**
 * Tell WordPress what to do during setup
 *
 */
if ( ! function_exists( 'tvdefault_setup' ) ):
function tvdefault_setup() {
	
	load_theme_textdomain( 'tvdefault', get_template_directory() . '/languages' );

	$locale = get_locale();
	$locale_file = get_template_directory() . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );

	add_theme_support( 'automatic-feed-links' );

	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'tvdefault' ),
	) );

	add_theme_support( 'custom-background', array(
		'default-color' => 'e4e4e4',
	) );

	add_theme_support( 'post-formats', array( 'aside', 'image', 'gallery' ) );
}
endif; // tvdefault_setup

/**
 * Tell WordPress to run tvdefault_setup() when the 'after_setup_theme' hook is run.
 */
add_action( 'after_setup_theme', 'tvdefault_setup' );

/**
 * Tell WordPress to customize the page title.
 */
function tvdefault_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'tvdefault' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'tvdefault_wp_title', 10, 2 );

/**
 * Set a default theme color array for WP.com.
 */
$themecolors = array(
	'bg' => 'ffffff',
	'border' => 'eeeeee',
	'text' => '444444',
);

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 */
function tvdefault_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'tvdefault_page_menu_args' );

/**
 * Register widgetized area and update sidebar with default widgets
 */
function tvdefault_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Sidebar 1', 'tvdefault' ),
		'id' => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h1 class="widget-title">',
		'after_title' => '</h1>',
	) );

	register_sidebar( array(
		'name' => __( 'Sidebar 2', 'tvdefault' ),
		'id' => 'sidebar-2',
		'description' => __( 'An optional second sidebar area', 'tvdefault' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h1 class="widget-title">',
		'after_title' => '</h1>',
	) );
}
add_action( 'widgets_init', 'tvdefault_widgets_init' );

if ( ! function_exists( 'tvdefault_content_nav' ) ):
/**
 * Display navigation to next/previous pages when applicable
 *
 */
function tvdefault_content_nav( $nav_id ) {
	global $wp_query;

	?>
	<nav id="<?php echo $nav_id; ?>">
		<h1 class="assistive-text section-heading"><?php _e( 'Post navigation', 'tvdefault' ); ?></h1>

	<?php if ( is_single() ) : // navigation links for single posts ?>

		<?php previous_post_link( '<div class="nav-previous">%link</div>', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'tvdefault' ) . '</span> %title' ); ?>
		<?php next_post_link( '<div class="nav-next">%link</div>', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'tvdefault' ) . '</span>' ); ?>

	<?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : // navigation links for home, archive, and search pages ?>

		<?php if ( get_next_posts_link() ) : ?>
		<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'tvdefault' ) ); ?></div>
		<?php endif; ?>

		<?php if ( get_previous_posts_link() ) : ?>
		<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'tvdefault' ) ); ?></div>
		<?php endif; ?>

	<?php endif; ?>

	</nav><!-- #<?php echo $nav_id; ?> -->
	<?php
}
endif; // tvdefault_content_nav

/**
 * Tell WordPress to enqueue scripts and styles
 *
 */
function tvdefault_scripts() {
	global $post;

	wp_enqueue_style( 'normalize', get_template_directory_uri() . '/css/normalize.css' );
	wp_enqueue_style( 'style', get_stylesheet_uri() );
	
	wp_enqueue_style( 'responsive', get_template_directory_uri() . '/css/responsive.css' );
	
	wp_enqueue_script( 'jquery' );
	
	wp_enqueue_script( 'menu-toggle', get_template_directory_uri() . '/js/small-menu.js');

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

}
add_action( 'wp_enqueue_scripts', 'tvdefault_scripts' );

/**
 * Tell WordPress to use a custom template for comments
 *
 */
if ( ! function_exists( 'tvdefault_comment' ) ) :

function tvdefault_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'tvdefault' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'tvdefault' ), ' ' ); ?></p>
	<?php
			break;
		default :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<footer>
				<div class="comment-author vcard">
					<?php echo get_avatar( $comment, 40 ); ?>
					<?php printf( __( '%s <span class="says">says:</span>', 'tvdefault' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
				</div><!-- .comment-author .vcard -->
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em><?php _e( 'Your comment is awaiting moderation.', 'tvdefault' ); ?></em>
					<br />
				<?php endif; ?>

				<div class="comment-meta commentmetadata">
					<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>"><time pubdate datetime="<?php comment_time( 'c' ); ?>">
					<?php
						/* translators: 1: date, 2: time */
						printf( __( '%1$s at %2$s', 'tvdefault' ), get_comment_date(), get_comment_time() ); ?>
					</time></a>
					<?php edit_comment_link( __( '(Edit)', 'tvdefault' ), ' ' );
					?>
				</div><!-- .comment-meta .commentmetadata -->
			</footer>

			<div class="comment-content"><?php comment_text(); ?></div>

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</article><!-- #comment-## -->

	<?php
			break;
	endswitch;
}
endif; // ends check for tvdefault_comment()

/**
 * Tell WordPress to output a custom posted on format.
 *
 */
if ( ! function_exists( 'tvdefault_posted_on' ) ) :

function tvdefault_posted_on() {
	printf( __( '<span class="sep">Posted on </span><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a><span class="byline"> <span class="sep"> by </span> <span class="author vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span></span>', 'tvdefault' ),
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( __( 'View all posts by %s', 'tvdefault' ), get_the_author() ) ),
		esc_html( get_the_author() )
	);
}
endif;

/**
 * Adds custom classes to the array of body classes.
 *
 */
function tvdefault_body_classes( $classes ) {
	if ( ! is_multi_author() ) {
		$classes[] = 'single-author';
	}

	return $classes;
}
add_filter( 'body_class', 'tvdefault_body_classes' );

/**
 * Returns true if a blog has more than 1 category
 *
 */
function tvdefault_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'all_the_cool_cats' ) ) ) {
		// Create an array of all the categories that are attached to posts
		$all_the_cool_cats = get_categories( array(
			'hide_empty' => 1,
		) );

		// Count the number of categories that are attached to the posts
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'all_the_cool_cats', $all_the_cool_cats );
	}

	if ( '1' != $all_the_cool_cats ) {
		// This blog has more than 1 category so tvdefault_categorized_blog should return true
		return true;
	} else {
		// This blog has only 1 category so tvdefault_categorized_blog should return false
		return false;
	}
}

/**
 * Flush out the transients used in tvdefault_categorized_blog
 *
 */
function tvdefault_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'all_the_cool_cats' );
}
add_action( 'edit_category', 'tvdefault_category_transient_flusher' );
add_action( 'save_post', 'tvdefault_category_transient_flusher' );

/**
 * Filter in a link to a content ID attribute for the next/previous image links on image attachment pages
 */
function tvdefault_enhanced_image_navigation( $url ) {
	global $post, $wp_rewrite;

	$id = (int) $post->ID;
	$object = get_post( $id );
	if ( wp_attachment_is_image( $post->ID ) && ( $wp_rewrite->using_permalinks() && ( $object->post_parent > 0 ) && ( $object->post_parent != $id ) ) )
		$url = $url . '#main';

	return $url;
}
add_filter( 'attachment_link', 'tvdefault_enhanced_image_navigation' );