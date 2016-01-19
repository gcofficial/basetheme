<?php
/**
 * Layouts/Container page right view
 *
 * @package photolab
 */
?>
<div class="col-sm-9">
	@while ( have_posts() )
		<?php the_post(); ?>
		@include('contents/page')
		@if ( comments_open() || '0' != get_comments_number() )
			<?php comments_template('/app/modules/custom/comments.php'); ?>
		@endif
	@endwhile
</div>
@include('layouts/sidebar-right')