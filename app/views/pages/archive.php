<?php
/**
 * Pages/archive view
 *
 * @package photolab
 */
?>{{ Main_Model::header() }}

	<div id="primary" class="container">
		<div class="row">
		{{ $breadcrumbs }}
		@include('layouts/container-index-'.$sidebar_side_type)
		</div>
	</div><!-- #primary -->

{{ Main_Model::footer() }}
