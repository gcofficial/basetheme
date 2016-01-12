<div class="col-sm-9 right-sidebar">
	@while ( have_posts() )
		<?php the_post(); ?>
		@include('contents/page')
		@if ( comments_open() || '0' != get_comments_number() )
			@include('blocks/comments')
		@endif
	@endwhile
</div>
@include('layouts/sidebar_left')