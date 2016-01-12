{{ MainModel::header() }}

	<div id="primary" class="container">
		<div class="row">
		{{ $breadcrumbs }}
		@if ( have_posts() )
			@while ( have_posts() )
				<?php the_post(); ?>
				@include('contents/content')
			@endwhile
			<?php photolab_paging_nav(); ?>
		@else
			@include('contents/none')
		@endif

		</div>
	</div><!-- #primary -->

{{ MainModel::footer() }}

