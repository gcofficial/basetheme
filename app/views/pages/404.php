{{ MainModel::header() }}

	<div id="primary" class="container">
		<div class="row">
			{{ $breadcrumbs }}
			<section class="error-404 not-found col-md-12">
				<header class="page-header">
					<h1 class="page-title">{{ __( 'Oops! That page can&rsquo;t be found.', 'photolab' ) }}</h1>
				</header><!-- .page-header -->

				<div class="page-content">
					<p>{{ __( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'photolab' ) }}</p>

					{{ $search_form }}

				</div><!-- .page-content -->
			</section><!-- .error-404 -->

		</div>
	</div><!-- #primary -->

{{ MainModel::footer() }}
