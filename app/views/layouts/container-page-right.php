<?php
/**
 * Layouts/Container page right view
 *
 * @package photolab
 */
?><div class="col-sm-9">
	@while ( have_posts() )
		<?php the_post(); ?>
		@include( 'contents/page' )
		@if ( comments_open() || get_comments_number() != '0' )
			<?php comments_template(); ?>
		@endif
	@endwhile
</div>
@include( 'layouts/sidebar-right' )
