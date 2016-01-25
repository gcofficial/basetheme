jQuery( document ).ready( function() {

	// Slider init
	if ( 'true' === window.TMSliderWidgetParam.autoplay ) {
		window.swiper_slider = new window.Swiper( '.tm-post-slider-widget', {
			pagination: '.tm-post-slider-widget .swiper-pagination',
			nextButton: '.tm-post-slider-widget .swiper-button-next',
			prevButton: '.tm-post-slider-widget .swiper-button-prev',
			slidesPerView: 1,
			paginationClickable: true,
			spaceBetween: 30,
			loop: true,
			direction: 'horizontal',
			speed: 2500,
			autoplay: 2500
		} );
	} else {
		window.swiper_slider = new window.Swiper( '.tm-post-slider-widget', {
			pagination: '.tm-post-slider-widget .swiper-pagination',
			nextButton: '.tm-post-slider-widget .swiper-button-next',
			prevButton: '.tm-post-slider-widget .swiper-button-prev',
			slidesPerView: 1,
			paginationClickable: true,
			spaceBetween: 30,
			loop: true,
			direction: 'horizontal',
			speed: 1000
		} );
	}
});
