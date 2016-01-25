<?php
/**
 * Admin view
 *
 * @package TM_Posts_Slider_Widget
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

	<div id="button-show">
		<label for="button_is">
			{{ __( 'Show button', PHOTOLAB_BASE_TM_ALIAS ) }}
			{{ $button_is_html }}
		</label>

		<p class="tm-post-slider-button-text" 
		   @if( 'false' == $button_is )
		   style="display: none;"
		   @endif
		>
			{{ $button_text_html }}
		</p>
	</div>
	<br/>

	<div>
		<label for="arrows_is">
		{{ __( 'Show arrows', PHOTOLAB_BASE_TM_ALIAS ) }}
		{{ $arrows_is_html }}
		</label>
	</div>
	<br/>

	<div>
		<label for="bullets_is">
		{{ __( 'Show bullets', PHOTOLAB_BASE_TM_ALIAS ) }}
		{{ $bullets_is_html }}
		</label>
	</div>
	<br/>

	<div>
		<label for="thumbnails_is">
		{{ __( 'Show thumb', PHOTOLAB_BASE_TM_ALIAS ) }}
		{{ $thumbnails_is_html }}
		</label>
	</div>
	<br/>

	<div>
		<label for="autoplay">
		{{ __( 'Autoplay', PHOTOLAB_BASE_TM_ALIAS ) }}
		{{ $autoplay_html }}
		</label>
	</div>

	<p>&nbsp;</p>
</div>
