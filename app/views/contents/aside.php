<?php
/**
 * Aside view
 *
 * @package photolab
 */
?>
<?php do_action( 'photolab_before_post' ); ?>
<article id="post-{{ get_the_ID() }}" class="{{ join( ' ', get_post_class() ) }}">

	<div class="entry-wrapper">
		<span class="entry-border"><div class="dashicons dashicons-format-aside"></div></span>
		<div class="entry-content-wrapper">
			<header class="entry-header">
				@if ( 'post' == get_post_type() )
					<div class="entry-meta">
						@include('blocks/posted-on')
					</div><!-- .entry-meta -->
				@endif
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

		</div><!-- .entry-wrapper -->
		<div class="clear"></div>
	</div><!-- .entry-content-wrapper -->
</article><!-- #post-## -->
