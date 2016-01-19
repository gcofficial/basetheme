<?php
/**
 * Breadcrumbs view
 * Sorry man, this is not my shit :-|
 *
 * @package photolab
 */
?>
@if ( !is_front_page() ) 
    <ul id="{{ $breadcrums_id }}" class="{{ $breadcrums_class }}">
    <li class="item-home"><a class="bread-link bread-home" href="{{ get_home_url() }}" title="{{ $home_title }}">{{ $home_title }}</a></li>
    <li class="separator separator-home"> {{ $separator }} </li>
       
    @if ( is_archive() && !is_tax() && !is_category() && !is_tag() ) 
        <li class="item-current item-archive"><strong class="bread-current bread-archive">{{ post_type_archive_title($prefix, false) }}</strong></li>
    @elseif ( is_archive() && is_tax() && !is_category() && !is_tag() )
        @if($post_type != 'post')
            <li class="item-cat item-custom-post-type-{{ $post_type }}"><a class="bread-cat bread-custom-post-type-{{ $post_type }}" href="{{ $post_type_archive }}" title="{{ $post_type_object->labels->name }}">{{ $post_type_object->labels->name }}</a></li>
            <li class="separator"> {{ $separator }} </li>
        @endif
        <li class="item-current item-archive"><strong class="bread-current bread-archive">{{ $custom_tax_name }}</strong></li>
    @elseif ( is_single() ) 
        @if($post_type != 'post')
            <li class="item-cat item-custom-post-type-{{ $post_type }}"><a class="bread-cat bread-custom-post-type-{{ $post_type }}" href="{{ $post_type_archive }}" title="{{ $post_type_object->labels->name }}">{{ $post_type_object->labels->name }}</a></li>
            <li class="separator"> {{ $separator }} </li>
        @endif
        
        @if(!empty($last_category))
            @if(!empty($category))
                @foreach($cat_parents as $parents)
                    <li class="item-cat">{{ $parents }}</li>
                    <li class="separator"> {{ $separator }} </li>
                @endforeach
            @endif
            <li class="item-current item-{{ $post->ID }}"><strong class="bread-current bread-{{ $post->ID }}" title="{{ get_the_title() }}">{{ get_the_title() }}</strong></li>
        @elseif(!empty($cat_id))
            <li class="item-cat item-cat-{{ $cat_id }} item-cat-{{ $cat_nicename }}"><a class="bread-cat bread-cat-{{ $cat_id }} bread-cat-{{ $cat_nicename }}" href="{{ $cat_link }}" title="{{ $cat_name }}">{{ $cat_name }}</a></li>
            <li class="separator"> {{ $separator }} </li>
            <li class="item-current item-{{ $post->ID }}"><strong class="bread-current bread-{{ $post->ID }}" title="{{ get_the_title() }}">{{ get_the_title() }}</strong></li>
        @else 
            <li class="item-current item-{{ $post->ID }}"><strong class="bread-current bread-{{ $post->ID }}" title="{{ get_the_title() }}">{{ get_the_title() }}</strong></li>
        @endif
    @elseif ( is_category() ) 
        <li class="item-current item-cat"><strong class="bread-current bread-cat">{{ single_cat_title('', false) }}</strong></li>
    @elseif ( is_page() ) 
        @if( $post->post_parent )
            @foreach ( $anc as $ancestor )
                <li class="item-parent item-parent-{{ $ancestor }}"><a class="bread-parent bread-parent-{{ $ancestor }}" href="{{ get_permalink($ancestor) }}" title="{{ get_the_title($ancestor) }}">{{ get_the_title($ancestor) }}</a></li>
                <li class="separator separator-{{ $ancestor }}"> {{ $separator }} </li>
            @endforeach
            <li class="item-current item-{{ $post->ID }}"><strong title="{{ get_the_title() }}"> {{ get_the_title() }}</strong></li>
        @else
            <li class="item-current item-{{ $post->ID }}"><strong class="bread-current bread-{{ $post->ID }}"> {{ get_the_title() }}</strong></li>
        @endif
    @elseif ( is_tag() ) 
        <li class="item-current item-tag-{{ $get_term_id }} item-tag-{{ $get_term_slug }}"><strong class="bread-current bread-tag-{{ $get_term_id }} bread-tag-{{ $get_term_slug }}">{{ $get_term_name }}</strong></li>
    @elseif ( is_day() ) 
        <li class="item-year item-year-{{ get_the_time('Y') }}"><a class="bread-year bread-year-{{ get_the_time('Y') }}" href="{{ get_year_link( get_the_time('Y') ) }}" title="{{ get_the_time('Y') }}">{{ get_the_time('Y') }} Archives</a></li>
        <li class="separator separator-{{ get_the_time('Y') }}"> {{ $separator }} </li>
        <li class="item-month item-month-{{ get_the_time('m') }}"><a class="bread-month bread-month-{{ get_the_time('m') }}" href="{{ get_month_link( get_the_time('Y'), get_the_time('m') ) }}" title="{{ get_the_time('M') }}">{{ get_the_time('M') }} Archives</a></li>
        <li class="separator separator-{{ get_the_time('m') }}"> {{ $separator }} </li>
        <li class="item-current item-{{ get_the_time('j') }}"><strong class="bread-current bread-{{ get_the_time('j') }}"> {{ get_the_time('jS') }} {{ get_the_time('M') }} Archives</strong></li>
    @elseif ( is_month() ) 
        <li class="item-year item-year-{{ get_the_time('Y') }}"><a class="bread-year bread-year-{{ get_the_time('Y') }}" href="{{ get_year_link( get_the_time('Y') ) }}" title="{{ get_the_time('Y') }}">{{ get_the_time('Y') }} Archives</a></li>
        <li class="separator separator-{{ get_the_time('Y') }}"> {{ $separator }} </li>
        <li class="item-month item-month-{{ get_the_time('m') }}"><strong class="bread-month bread-month-{{ get_the_time('m') }}" title="{{ get_the_time('M') }}">{{ get_the_time('M') }} Archives</strong></li>
    @elseif ( is_year() ) 
        <li class="item-current item-current-{{ get_the_time('Y') }}"><strong class="bread-current bread-current-{{ get_the_time('Y') }}" title="{{ get_the_time('Y') }}">{{ get_the_time('Y') }} Archives</strong></li>
    @elseif ( is_author() ) 
        <li class="item-current item-current-{{ $userdata->user_nicename }}"><strong class="bread-current bread-current-{{ $userdata->user_nicename }}" title="{{ $userdata->display_name }}">Author: {{ $userdata->display_name }}</strong></li>
    @elseif ( get_query_var('paged') ) 
        <li class="item-current item-current-{{ get_query_var('paged') }}"><strong class="bread-current bread-current-{{ get_query_var('paged') }}" title="Page {{ get_query_var('paged') }}">{{ __('Page', 'photolab') }} {{ get_query_var('paged') }}</strong></li>
    @elseif ( is_search() ) 
        <li class="item-current item-current-{{ get_search_query() }}"><strong class="bread-current bread-current-{{ get_search_query() }}" title="Search results for: {{ get_search_query() }}">Search results for: {{ get_search_query() }}</strong></li>
    @elseif ( is_404() ) 
        <li>Error 404</li>
    @endif
    </ul>
@endif
