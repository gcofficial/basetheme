<?php
/**
 * Widgets/Front end/Advertisement view
 *
 * @package photolab
 */
?>{{ $before_widget }}
@if($title != '')
	{{ $before_title }}{{ apply_filters( 'widget_title', $title ) }}{{ $after_title }}
@endif
@if(trim($image) != '')
	<img src="{{ $image }}" alt="image">
@else
	<span class="none">Image not found!</span>
@endif
{{ $after_widget }}