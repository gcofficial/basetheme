<?php
/**
 * Contents/Link view
 *
 * @package photolab
 */
?><?php do_action( 'photolab_before_post' ); ?>
<article id="post-{{ get_the_ID() }}" class="{{ join( ' ', get_post_class() ) }} col-md-12">

	<div class="entry-wrapper">
		<span class="entry-border"><div class="dashicons dashicons-admin-links"></div></span>
		<div class="entry-content-wrapper">
			<header class="entry-header">
				@if ( 'post' == get_post_type() )
					<div class="entry-meta">
						@include('blocks/posted-on')
					</div><!-- .entry-meta -->
					{{ the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>', false ) }}
				@endif
			</header><!-- .entry-header -->

			<div class="entry-content">
				@if( !$is_show_title_on_header )
					@include('blocks/title')
				@endif
				{{ get_the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'photolab' ) ) }}
				{{ wp_link_pages( 
					array(
						'before' => '<div class="page-links">' . __( 'Pages:', 'photolab' ),
						'after'  => '</div>',
						'echo'   => false
					) 
				) }}
			</div><!-- .entry-content -->

		</div><!-- .entry-wrapper -->
		<div class="clear"></div>
	</div><!-- .entry-content-wrapper -->
</article><!-- #post-## -->
