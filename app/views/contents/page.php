<?php
/**
 * Contents/Page view
 *
 * @package photolab
 */
?><article id="post-{{ get_the_ID() }}" class="{{ join( ' ', get_post_class() ) }} col-md-12">

	<div class="entry-content">
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
	</div><!-- .entry-content -->
</article><!-- #post-## -->
