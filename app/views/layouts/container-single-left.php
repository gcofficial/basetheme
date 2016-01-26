<?php
/**
 * Layouts/Container single left sidebar view
 *
 * @package photolab
 */
?><div class="col-sm-9 right-sidebar">
{{ $social_post_code }}
@while ( have_posts() )
	<?php the_post(); ?>
	@include( 'contents/single' )
	@if ( comments_open() || get_comments_number() != '0' )
		<?php comments_template(); ?>
	@endif
@endwhile
</div>
@include( 'layouts/sidebar-left' )
