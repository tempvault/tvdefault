<?php
/**
 * The template for displaying posts in the Image Post Format on index and archive pages
 *
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'tvdefault' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'tvdefault' ) ); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'tvdefault' ), 'after' => '</div>' ) ); ?>
	</div><!-- .entry-content -->

	<footer class="entry-meta">
		<?php tvdefault_posted_on(); ?>
		<?php if ( comments_open() || ( '0' != get_comments_number() && ! comments_open() ) ) : ?>
		<span class="sep"> | </span>
		<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'tvdefault' ), __( '1 Comment', 'tvdefault' ), __( '% Comments', 'tvdefault' ) ); ?></span>
		<?php endif; ?>
		<?php edit_post_link( __( 'Edit', 'tvdefault' ), '<span class="sep"> | </span><span class="edit-link">', '</span>' ); ?>
	</footer><!-- #entry-meta -->
</article><!-- #post-<?php the_ID(); ?> -->
