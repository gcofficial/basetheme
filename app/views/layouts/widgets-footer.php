<?php
/**
 * Layouts/Widget footer view
 *
 * @package photolab
 */
?>@if(count($widgets) > 0 && $columns > 0)
	@for($i = 0; $i < count($widgets); $i+=$columns)
		<div class="row">
		@for ($x=0; $x < $columns; $x++) 
			@if(array_key_exists($i + $x, $widgets))
				<div class="{{ $css }}">{{ $widgets[$i + $x] }}</div>
			@endif
		@endfor
		</div>
	@endfor
@endif
