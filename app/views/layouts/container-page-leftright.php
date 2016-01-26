<?php
/**
 * Layouts/Container page left and right sidebars view
 *
 * @package photolab
 */
?>@include( 'layouts/sidebar-left' )
<div class="col-sm-6">
	@while ( have_posts() )
		<?php the_post(); ?>
		@include( 'contents/page' )
		@if ( comments_open() || get_comments_number() != '0' )
			<?php comments_template(); ?>
		@endif
	@endwhile
</div>
@include( 'layouts/sidebar-right' )
