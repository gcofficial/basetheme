@for($i = 0; $i < count($posts); $i+=$columns_count)
	<div class="row">
	@for($x = 0; $x < $columns_count; $x++)
	
		@if(isset($posts[$i+$x]))
			<?php
			$post = $posts[$i+$x];
			setup_postdata( $post );
			?>
			<div class="{{ $column_css_class }}">
				@include( 'contents/'.BlogSettingsModel::getContentName() )
			</div>
				
		@endif

	@endfor
	</div>
@endfor
