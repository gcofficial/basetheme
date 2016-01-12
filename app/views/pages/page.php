{{ MainModel::header() }}

	<div id="primary" class="container">
		<div class="row">
			{{ $breadcrumbs }}
			@include('layouts/container-page-'.$sidebar_side_type)
		</div><!-- #main -->
	</div><!-- #primary -->

{{ MainModel::footer() }}
