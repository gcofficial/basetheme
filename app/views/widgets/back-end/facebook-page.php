<?php
/**
 * Admin view
 *
 * @package TM_Facebook_Page_Widget
 */
?>

<div class="tm-facebook-page-form-widget">
	<p>
		{{ $title_html }}
	</p>

	<p>
		{{ $app_id_html }}
	</p>

	<p>
		{{ $page_title_html }}
	</p>

	<p>
		{{ $facebook_url_html }}
	</p>

	<p>
		<label>{{ __( 'Tabs', PHOTOLAB_BASE_TM_ALIAS ) }}</label>
		{{ $tabs_html }}
	</p>

	<p>
		{{ $width_html }}
	</p>

	<p>
		{{ $height_html }}
	</p>

	<div>
		<label>
		{{ __( 'Small header', PHOTOLAB_BASE_TM_ALIAS ) }}
		{{ $small_header_html }}
		</label>
	</div>
	<br/>

	<div>
		<label>
		{{ __( 'Adaptive width', PHOTOLAB_BASE_TM_ALIAS ) }}
		{{ $adaptive_width_html }}
		</label>
	</div>
	<br/>

	<div>
		<label>
		{{ __( 'Hide cover', PHOTOLAB_BASE_TM_ALIAS ) }}
		{{ $hide_cover_html }}
		</label>
	</div>
	<br/>

	<div>
		<label>
		{{ __( 'Freind`s face', PHOTOLAB_BASE_TM_ALIAS ) }}
		{{ $freinds_face_html }}
		</label>
	</div>

	<p>&nbsp;</p>
</div>
