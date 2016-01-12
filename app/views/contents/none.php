<section class="no-results not-found col-md-12">
	<header class="page-header">
		<h2 class="page-title">{{ __( 'Nothing Found', 'photolab' ) }}</h2>
	</header><!-- .page-header -->

	<div class="page-content">
		@if ( is_home() && current_user_can( 'publish_posts' ) ) 
			<p>{{ sprintf( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'photolab' ), esc_url( admin_url( 'post-new.php' ) ) ) }}</p>

		@elseif ( is_search() )
			<p>{{ __( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'photolab' ) }} </p>
			{{ $search_form }}
		@else
			<p>{{ __( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'photolab' ) }}</p>
			{{ $search_form }}
		@endif
	</div><!-- .page-content -->
</section><!-- .no-results -->
gurievcreative@gmail.com