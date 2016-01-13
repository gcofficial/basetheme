<div class="home-link">
	<h1 class="displaying-header-text"><a id="name" onclick="return false;" href="#">{{ $name }}</a></h1>
	<h2 id="desc" class="displaying-header-text">{{ $description }}</h2>
</div>
<div id="headimg">
	<img src="{{ esc_url(get_header_image()) }}" alt="header-image">
	@if( $header_slogan ) 
		<div class="header-slogan">{{ wp_kses( $header_slogan, $allowedtags ) }}</div>
	@endif
</div>