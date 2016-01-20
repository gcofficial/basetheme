<?php
/**
 * Gallery module file
 *
 * @package photolab
 */

namespace Modules\Custom;

use View;
use Utils;

/**
 * Fuck that shit!!!
 * When we have time, it will be necessary
 * to refactoring this code.
 *
 * Thnx bro for understanding. :-|
 */
class Gallery {

	/**
	 * Get image html for featured gallery
	 *
	 * @param int  $id - image ID.
	 * @param type $size - image size.
	 * @param type $class - image wrapper class.
	 * @return string - HTNL markup for gallery tem image.
	 */
	public static function get_image_html( $id = null, $size = 'fullwidth-thumbnail', $class = 'fullwidth-item' ) {
		if ( ! $id ) {
			return;
		}
		$fullsize_img  = wp_get_attachment_url( $id );
		$cropped_image = wp_get_attachment_image( $id, $size );
		if ( $fullsize_img  && $cropped_image ) {
			return View::make(
				'blocks/gall-img',
				[
					'class'         => $class,
					'fullsize_img'  => $fullsize_img,
					'cropped_image' => $cropped_image,
				]
			);
		}
		return false;
	}

	/**
	 * Show featured gllery for gallery post format
	 *
	 * @return void
	 */
	public static function get_featured_gallery_html( $img_ids = null ) {

		if ( ! $img_ids || ! is_array( $img_ids ) ) {
			return;
		}

		$post_id = get_the_id();

		$img_ids_chunks = array_chunk( $img_ids, 3 );
		$num_items = count( $img_ids_chunks );
		$i = 0;
		$rows = [];

		foreach ( $img_ids_chunks as $sub_ids ) {
			$items = [];
			$item_class = 'item-left';
			if ( 0 == ( ( $i + 1 ) % 2 ) ) {
				$item_class = 'item-right';
			}
			if ( ++$i === $num_items ) {
				$sub_ids_length = count( $sub_ids );
				switch ( $sub_ids_length ) {
					case '1':
						array_push( $items, self::get_image_html( $sub_ids[0] ) );
						break;

					case '2':
						foreach ( $sub_ids as $img_item ) {
							array_push( $items, self::get_image_html( $img_item, 'gallery-large', 'half-width-item' ) );
						}
						unset( $img_item );
						break;

					case '3':
						$sub_iter = 1;
						foreach ( $sub_ids as $img_item ) {
							if ( 1 == $sub_iter ) {
								array_push( $items, self::get_image_html( $img_item, 'gallery-large', 'large-img-item' ) );
								$sub_iter++;
							} else {
								array_push( $items, self::get_image_html( $img_item, 'gallery-small', 'small-img-item' ) );
							}
						}
						unset( $img_item );
						unset( $sub_iter );
						break;
				}
				array_push(
					$rows,
					View::make(
						'blocks/gall-row',
						[
							'item_class' => 'last '.$item_class,
							'items'      => $items,
						]
					)
				);
			} else {
				$sub_iter = 1;
				foreach ( $sub_ids as $img_item ) {
					if ( 1 == $sub_iter ) {
						array_push( $items, self::get_image_html( $img_item, 'gallery-large', 'large-img-item' ) );
						$sub_iter++;
					} else {
						array_push( $items, self::get_image_html( $img_item, 'gallery-small', 'small-img-item' ) );
					}
				}
				unset( $img_item );
				unset( $sub_iter );

				array_push(
					$rows,
					View::make(
						'blocks/gall-row',
						[
							'item_class' => $item_class,
							'items'      => $items,
						]
					)
				);
			}
		}
		echo View::make(
			'blocks/gall',
			[
				'rows'    => $rows,
				'post_id' => $post_id,
			]
		);

	}

	/**
	 * Featured gallery for gallery post format
	 */
	public static function featured_gallery( $post_format_only = true ) {
		if ( $post_format_only && 'gallery' != get_post_format() ) {
			return;
		}

		$post_id = get_the_id();
		$post_gallery = get_post_gallery( $post_id, false );

		if ( $post_gallery && is_array( $post_gallery ) && isset( $post_gallery['ids'] ) ) {
			$img_ids = explode( ',', $post_gallery['ids'] );

			self::get_featured_gallery_html( $img_ids );
		} else {
			$attachments = get_children(
				[
					'post_parent'    => $post_id,
					'posts_per_page' => 3,
					'post_status'    => 'inherit',
					'post_type'      => 'attachment',
					'post_mime_type' => 'image',
				]
			);

			if ( $attachments && is_array( $attachments ) ) {
				$img_ids = array_keys( $attachments );
				self::get_featured_gallery_html( $img_ids );
			}
		}
	}
}
