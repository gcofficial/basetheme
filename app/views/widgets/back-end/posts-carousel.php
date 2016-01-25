<?php
/**
 * Admin view
 *
 * @package TM_Posts_Widget
 */
?>

<div class="tm-post-slider-form-widget">
	<p>
		{{ $title_html }}
	</p>

	<p>
		<label for="categories">{{ __( 'Category', PHOTOLAB_BASE_TM_ALIAS ) }}</label>
		{{ $categories_html }}
	</p>

	<p>
		<label for="tags">{{ __( 'Tag', PHOTOLAB_BASE_TM_ALIAS ) }}</label>
		{{ $tags_html }}
	</p>

	<p>
		{{ $count_html }}
	</p>

	<p>
		{{ $slides_per_view_html }}
	</p>

	<p>
		{{ $length_html }}
	</p>

	<p>&nbsp;</p>
</div>
