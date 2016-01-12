@if ( has_excerpt() ) 
	{{ get_the_excerpt() }}
@else 
	{{ wp_trim_words( get_the_content(), 110 ) }}
@endif