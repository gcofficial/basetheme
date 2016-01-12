{{ MainModel::header() }}
	<div id="primary" class="container">
		<div class="row">
		{{ $breadcrumbs }}
		@include('layouts/container-single-'.$sidebar_side_type)
		</div>
	</div><!-- #primary -->
{{ MainModel::footer() }}