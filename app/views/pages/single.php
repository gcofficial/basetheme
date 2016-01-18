{{ Main_Model::header() }}
	<div id="primary" class="container">
		<div class="row">
		{{ $breadcrumbs }}
		@include('layouts/container-single-'.$sidebar_side_type)
		</div>
	</div><!-- #primary -->
{{ Main_Model::footer() }}