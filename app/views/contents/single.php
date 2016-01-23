<?php
/**
 * Contents/Single view
 *
 * @package photolab
 */
?><article id="post-{{ get_the_ID() }}" class="{{ join( ' ', get_post_class() ) }} col-md-12">

	<?php Gallery::featured_gallery(); ?>

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

	<footer class="entry-footer">
		<div class="entry-footer-item meta-user"><div class="dashicons dashicons-businessman"></div> <?php the_author_posts_link(); ?></div>
		@if ($category_list)
			<div class="entry-footer-item meta-category"><div class="dashicons dashicons-category"></div> {{ $category_list }}</div>
		@endif
		@if ($tag_list)
			<div class="entry-footer-item meta-tags"><div class="dashicons dashicons-tag"></div> {{ $tag_list }}</div>
		@endif
	</footer><!-- .entry-footer -->

</article><!-- #post-## -->
