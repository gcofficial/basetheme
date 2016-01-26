<?php
/**
 * Акщте view
 *
 * @package TM_Custom_Posts_Widget
 */
?>
{{ $before_widget }}
@if($title != '')
	{{ $before_title }}{{ apply_filters( 'widget_title', $title ) }}{{ $after_title }}
@endif
<div class="tm-custom-posts-widget">
	@if(count($posts))
	<div class="posts">
		@foreach($posts as $post)
		<div class="post">
			<h4>
				<a href="{{ get_permalink($post->ID) }}">
					{{ $post->post_title }}
				</a>
			</h4>
			<div class="metadata">
				@if( 'true' == $show_date )
				<span>{{ $post->post_date }}</span>
				@endif

				@if( 'true' == $show_author )
				<span>{{ get_the_author_meta( 'display_name', $post->post_author ) }}</span>
				@endif

				@if( 'true' == $show_comments )
				<span>{{ sprintf( __( 'One Comment', '%1$s Comments', get_comments_number(), '', PHOTOLAB_BASE_TM_ALIAS ), number_format_i18n( get_comments_number() ) ) }}</span>
				@endif

				@if( 'true' == $show_categories )
				<span>{{ get_the_term_list( $post->ID, 'category', '<ul class="categories"><li>', ',</li><li>', '</li></ul>' ) }}</span>
				@endif

				@if( 'true' == $show_tags )
				<span>{{ get_the_term_list( $post->ID, 'post_tag', '<ul class="tags"><li>', ',</li><li>', '</li></ul>' ) }}</span>
				@endif
			</div>
			<div class="excerpt">
				<img src="{{ $post->image }}" class="alignleft">
				{{ $post->post_excerpt }}
				@if ( '' != $button_text )
				<a class="read-more" href="{{ get_permalink($post->ID) }}">
					{{ $button_text }}
				</a>
				@endif
			</div>
		</div>
		@endforeach
	</div>
	@endif
</div>
{{ $after_widget }}
