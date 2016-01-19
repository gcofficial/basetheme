<?php
/**
 * Blocks/Title view
 *
 * @package photolab
 */
?>@if ( is_category() )
	<h1> {{ single_cat_title('', false) }}</h1>
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