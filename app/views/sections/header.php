<?php
/**
 * Sections/Header view
 *
 * @package photolab
 */
?><!DOCTYPE html>
<html {{ $language_attributes }}>
<head>
<meta charset="{{ $charset }}">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="{{ $ping_back_url }}">
{{ $favicon }}
{{ $touch_icon }}
<!--[if lt IE 9]>
<script src="{{ $TDU }}/js/html5.js" type="text/javascript"></script>
<![endif]-->

<?php wp_head(); ?>
</head>
{{ $custom_styles }}
<body {{ $body_class }}>
@if($is_enabled_preloader)
	@include('blocks/loader')
@endif
<div id="page" class="hfeed site">
	@if(has_nav_menu('top'))
		@include('blocks/top-menu')
	@endif
	@include('layouts/'.$header_layout_view)
	<div class="header-image-box">
	@if ( is_front_page() )
		@if ( $header_image )
			<img src="{{ $header_image }}" alt="{{ get_bloginfo( 'name' ) }}">
		@endif
		@if ( $header_slogan && $header_image )
			<div class="header-slogan {{ esc_attr( $static_class ) }}">{{ $header_slogan }}</div>
		@endif
	@else
		<div class="page-header-wrap">
		@if ( is_singular() ) 
			@if ( has_post_thumbnail() ) 
				{{ get_the_post_thumbnail( get_the_id(), 'full' ) }}
			@elseif ( $header_image ) 
				<img src="{{ esc_url( $header_image ) }}" alt="{{ get_bloginfo( 'name' ) }}">
			@endif
		@else 
			@if ( $header_image ) 
				<img src="{{ esc_url( $header_image ) }}" alt="{{ get_bloginfo( 'name' ) }}">
			@endif
		@endif
			<div class="container">
				<div class="{{ esc_attr( $header_class ) }}">
					
					@if ( is_category() )
						<h1>{{ single_cat_title('', false) }}</h1>
					@elseif ( is_tag() ) 
						<h1>{{ single_tag_title('', false) }}</h1>
					@elseif ( is_author() ) 
						<h1>{{ sprintf( __( 'Author: %s', 'photolab' ), '<span class="vcard">' . get_the_author() . '</span>' ) }}</h1>
					@elseif ( is_day() )
						<h1>{{ sprintf( __( 'Day: %s', 'photolab' ), '<span>' . get_the_date() . '</span>' ) }}</h1>
					@elseif ( is_month() )
						<h1>{{ sprintf( __( 'Month: %s', 'photolab' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'photolab' ) ) . '</span>' ) }}</h1>
					@elseif ( is_year() )
						<h1>{{ sprintf( __( 'Year: %s', 'photolab' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'photolab' ) ) . '</span>' ) }}</h1>
					@elseif ( is_tax( 'post_format', 'post-format-aside' ) )
						<h1>{{ __( 'Asides', 'photolab' ) }}</h1>
					@elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) 
						<h1>{{ __( 'Galleries', 'photolab') }}</h1>
					@elseif ( is_tax( 'post_format', 'post-format-image' ) )
						<h1>{{ __( 'Images', 'photolab') }}</h1>
					@elseif ( is_tax( 'post_format', 'post-format-video' ) )
						<h1>{{ __( 'Videos', 'photolab' ) }}</h1>
					@elseif ( is_tax( 'post_format', 'post-format-quote' ) )
						<h1>{{ __( 'Quotes', 'photolab' ) }}</h1>
					@elseif ( is_tax( 'post_format', 'post-format-link' ) )
						<h1>{{ __( 'Links', 'photolab' ) }}</h1>
					@elseif ( is_tax( 'post_format', 'post-format-status' ) )
						<h1>{{ __( 'Statuses', 'photolab' ) }}</h1>
					@elseif ( is_tax( 'post_format', 'post-format-audio' ) )
						<h1>{{ __( 'Audios', 'photolab' ) }}</h1>
					@elseif ( is_tax( 'post_format', 'post-format-chat' ) )
						<h1>{{ __( 'Chats', 'photolab' ) }}</h1>
					@elseif ( is_search() )
						<h1 class="page-title">{{ sprintf( __( 'Search Results for: %s', 'photolab' ), '<span>' . get_search_query() . '</span>' ) }}</h1>
					@elseif ( is_single() )
						<div class="entry-meta">
							@include('blocks/posted-on')
						</div><!-- .entry-meta -->
						{{ the_title( '<h1 class="entry-title">', '</h1>', false ) }}
					@elseif ( is_page() )
						{{ the_title( '<h1 class="entry-title">', '</h1>', false ) }}
					@elseif ( is_404() )
						<h1 class="entry-title">{{ __( 'Error 404', 'photolab' ) }}</h1>
					@else
						<h1>{{ __( 'Archives', 'photolab' ) }}</h1>
					@endif

					@if ( ! empty( $term_description ) )
						<div class="taxonomy-description">{{ $term_description }}</div>
					@endif
				</div>
			</div>
		</div>
	@endif
	</div>
	@if ( is_front_page() )
		@if ( ! empty($data) AND ! ($wp_query->is_paged && $wp_query->query['paged'] > 1) ) 
		@endif	

		<div class="container">
			<div class="welcome_message row">
				@if ( isset($welcome_message['welcome_label']) )
					<div class="col-md-12"><h3 class="message_label"><span>{{ wp_kses( $welcome_message['welcome_label'], $allowedtags ) }}</span></h3></div>
				@endif
				@if ( isset($welcome_message['welcome_img']) ) 
					<div class="col-md-5"><img src="{{ esc_url( $welcome_message['welcome_img'] ) }}" alt="{{ esc_attr( $alt_mess ) }}"></div>
				@endif
				<div class="message_content col-md-7">
					@if ( isset($welcome_message['welcome_title']) )
						<h2 class="message_title">{{ wp_kses( $welcome_message['welcome_title'], $allowedtags ) }}</h2>
					@endif
					@if ( isset($welcome_message['welcome_message']) )
						<p>{{ wp_kses( $welcome_message['welcome_message'], $allowedtags ) }}</p>
					@endif
				</div>
			</div>
		</div>
	@endif
	<div id="content" class="site-content">
