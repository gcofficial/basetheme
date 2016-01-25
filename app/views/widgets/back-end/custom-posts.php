<?php
/**
 * Admin view
 *
 * @package TM_Custom_Posts_Widget
 */
?>

<div class="tm-custom-posts-form-widget">
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
		{{ $title_length_html }}
	</p>

	<p>
		{{ $excerpt_length_html }}
	</p>

	<p>
		{{ $button_text_html }}
	</p>

	<div>
		<label for="show_date">{{ __( 'Show date', PHOTOLAB_BASE_TM_ALIAS ) }}</label>
		{{ $show_date_html }}
	</div>
	<br/>

	<div>
		<label for="show_author">{{ __( 'Show author', PHOTOLAB_BASE_TM_ALIAS ) }}</label>
		{{ $show_author_html }}
	</div>
	<br/>

	<div>
		<label for="show_comments">{{ __( 'Show comments', PHOTOLAB_BASE_TM_ALIAS ) }}</label>
		{{ $show_comments_html }}
	</div>
	<br/>

	<div>
		<label for="show_categories">{{ __( 'Show categories', PHOTOLAB_BASE_TM_ALIAS ) }}</label>
		{{ $show_categories_html }}
	</div>
	<br/>

	<div>
		<label for="show_tags">{{ __( 'Show tags', PHOTOLAB_BASE_TM_ALIAS ) }}</label>
		{{ $show_tags_html }}
	</div>

	<p>&nbsp;</p>
</div>
