<?php
/**
 * Layouts/Container page left view
 *
 * @package photolab
 */
?><div class="col-sm-9 right-sidebar">
	@while ( have_posts() )
		<?php the_post(); ?>
		@include( 'contents/page' )
		@if ( comments_open() || get_comments_number() != '0' )
			<?php comments_template( '/app/modules/custom/comments.php' ); ?>
		@endif
	@endwhile
</div>
@include( 'layouts/sidebar-left' )
