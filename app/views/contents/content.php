<?php
/**
 * Contents/Content view
 *
 * @package photolab
 */
?><?php do_action( 'photolab_before_post' ); ?>
<article id="post-{{ get_the_ID() }}" class="{{ join( ' ', get_post_class() ) }} col-md-12">

	<div class="entry-wrapper">
		<span class="entry-border"><div class="dashicons dashicons-editor-alignleft"></div></span>
		@if ( has_post_thumbnail() )
			<figure class="featured-thumbnail {{ esc_attr( Misc_Model::get_blog_image() ) }}">
				<a href="{{ get_permalink() }}">
					{{ get_the_post_thumbnail( get_the_ID(), Misc_Model::get_blog_image() ) }}
					<span class="img-mask"></span>
				</a>
			</figure>
		@endif
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
					<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'photolab' ) ) ?>
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
