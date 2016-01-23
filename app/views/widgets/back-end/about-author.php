<?php
/**
 * Admin view
 *
 * @package TM_Posts_Widget
 */
?>
<!-- Widget Form -->
<div class="tm-about-author-form-widget">
	<p>
		{{ $title_html }}
	</p>

	<p>
		<label for="user_id">{{ __( 'Author', PHOTOLAB_BASE_TM_ALIAS ) }}</label>
		{{ $users_html }}
	</p>

	<p>
		{{ $url_html }}
	</p>

	<p>
		{{ $text_link_html }}
	</p>

	<p>
		<label>{{ __( 'Custom image', PHOTOLAB_BASE_TM_ALIAS ) }}</label><br/>
		{{ $upload_html }}
		{{ $delete_image_html }}
		{{ $image_html }}
	</p>

	<p class="avatar" id="{{ $avatar_id }}">
		<img default_image="{{ $default_image }}" src="{{ $avatar }}">
	</p>

	<p>&nbsp;</p>
</div>
<!-- End widget Form -->
