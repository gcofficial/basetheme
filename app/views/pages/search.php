<?php
/**
 * Pages/Search view
 *
 * @package photolab
 */
?>{{ Main_Model::header() }}

	<div id="primary" class="container">
		<div class="row">
		{{ $breadcrumbs }}
		@if ( have_posts() )
			@while ( have_posts() )
				<?php the_post(); ?>
				@include('contents/content')
			@endwhile
			{{ $paginate_links }}
		@else
			@include('contents/none')
		@endif

		</div>
	</div><!-- #primary -->

{{ Main_Model::footer() }}
