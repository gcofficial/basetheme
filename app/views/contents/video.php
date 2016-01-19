<?php
/**
 * Contents/Video view
 *
 * @package photolab
 */
?>
<?php do_action( 'photolab_before_post' ); ?>
<article id="post-{{ get_the_ID() }}" class="{{ join( ' ', get_post_class() ) }} col-md-12">

	<div class="entry-wrapper">
		<span class="entry-border"><div class="dashicons dashicons-video-alt3"></div></span>
		<div class="entry-content-wrapper">
			<header class="entry-header">
				@if ( 'post' == get_post_type() )
					<div class="entry-meta">
						@include('blocks/posted-on')
					</div><!-- .entry-meta -->
				@endif
				{{ the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>', false ) }}
			</header><!-- .entry-header -->

			@if ( is_search() )
			<div class="entry-summary">
				@include('blocks/excerpt')
			</div><!-- .entry-summary -->
			@else
			<div class="entry-content">
				@if( 'excerpt' == $blog_content )
					@include('blocks/excerpt')
				@else
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
				@endif
			</div><!-- .entry-content -->
			@endif
			@include('blocks/read-more-button')
		</div><!-- .entry-wrapper -->
		<div class="clear"></div>
	</div><!-- .entry-content-wrapper -->
</article><!-- #post-## -->
