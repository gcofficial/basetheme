<?php
/**
 * Custom template tags for this theme.
 *
 * based on Underscores starter WordPress theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package photolab
 */

/**
 * Get image html for featured gallery
 * @param  int $id - image ID
 * @param  string $size - image size
 * @param  string $class - image wrapper class
 * @return string - HTNL markup for gallery tem image
 */
function photolab_get_image_html( $id = null, $size = 'fullwidth-thumbnail', $class = 'fullwidth-item' ) {
	if ( !$id ) {
		return;
	}
	$fullsize_img = wp_get_attachment_url( $id );
	$cropped_image = wp_get_attachment_image( $id, $size );
	if ( $fullsize_img  && $cropped_image  ) {
		$result = '<div class="gall-img-wrap ' . esc_attr( $class ) . '"><a href="' . esc_url( $fullsize_img ) . '" class="lightbox-gallery">' . $cropped_image . '<span class="img-mask"></span></a></div>';
		return $result;
	} else {
		return false;
	}

}

/**
 * Show featured gllery for gallery post format
 * @return void
 */
function photolab_get_featured_gallery_html( $img_ids = null ) {

	if ( !$img_ids || !is_array($img_ids) ) {
		return;
	}

	$post_id = get_the_id();

	$img_ids_chunks = array_chunk($img_ids, 3);
	$num_items = count($img_ids_chunks);
	$i = 0;

	echo '<div class="post-featured-gallery" id="featured-gallery-' . $post_id . '" data-gall-id="featured-gallery-' . $post_id . '">';

	foreach ($img_ids_chunks as $sub_ids) {
		$item_class = 'item-left';
		if ( 0 == ( ( $i + 1 ) % 2 ) ) {
			$item_class = 'item-right';
		}
		if(++$i === $num_items) {

			// Gallery last row start
			echo '<div class="gall-row last ' . esc_attr( $item_class ) . '">';
			
			$sub_ids_length = count($sub_ids);
			switch ($sub_ids_length) {
				case '1':
					echo photolab_get_image_html($sub_ids[0]);
					break;
				
				case '2':
					foreach ($sub_ids as $img_item) {
						echo photolab_get_image_html($img_item, 'gallery-large', 'half-width-item');
					}
					unset($img_item);
					break;

				case '3':
					$sub_iter = 1;
					foreach ($sub_ids as $img_item) {
						if ( 1 == $sub_iter ) {
							echo photolab_get_image_html($img_item, 'gallery-large', 'large-img-item');
							$sub_iter++;
						} else {
							echo photolab_get_image_html($img_item, 'gallery-small', 'small-img-item');
						}
					}
					unset($img_item);
					unset($sub_iter);
					break;
			}

			// Gallery last row finish
			echo '</div>';

		} else {

			// Gallery row start
			echo '<div class="gall-row ' . esc_attr( $item_class ) . '">';

			$sub_iter = 1;
			foreach ($sub_ids as $img_item) {
				if ( 1 == $sub_iter ) {
					echo photolab_get_image_html($img_item, 'gallery-large', 'large-img-item');
					$sub_iter++;
				} else {
					echo photolab_get_image_html($img_item, 'gallery-small', 'small-img-item');
				}
			}
			unset($img_item);
			unset($sub_iter);
			
			// Gallery last row finish
			echo '</div>';
		}
	}

	echo '</div>';

}

/**
 * Featured gallery for gallery post format
 */
function photolab_featured_gallery( $post_format_only = true ) {

	if ( $post_format_only && 'gallery' != get_post_format() ) {
		return;
	}
	
	$post_id = get_the_id();
	$post_gallery = get_post_gallery( $post_id, false );

	if ( $post_gallery && is_array($post_gallery) && isset($post_gallery['ids']) ) {
		$img_ids = explode(',', $post_gallery['ids']);

		photolab_get_featured_gallery_html( $img_ids );
	} else {

		$attachments = get_children( array(
			'post_parent'    => $post_id,
			'posts_per_page' => 3,
			'post_status'    => 'inherit',
			'post_type'      => 'attachment',
			'post_mime_type' => 'image',
		) );

		if ( $attachments && is_array($attachments) ) {
			$img_ids = array_keys($attachments);
			photolab_get_featured_gallery_html( $img_ids );
		}

	}

}

/**
 * Get image for image post format
 */
function photolab_image_post() {

	if ( has_post_thumbnail() ) {
		$thumb_id = get_post_thumbnail_id();
		$fullsize_img = wp_get_attachment_url( $thumb_id );
		$cropped_image = wp_get_attachment_image( $thumb_id , 'fullwidth-thumbnail' );
		echo '<figure class="lightbox-image"><a href="' . esc_url( $fullsize_img ) . '" class="lightbox-gallery">' . $cropped_image . '<span class="img-mask"></span></a></figure>';
	} else {
		$post_id = get_the_id();
		$attachments = get_children( array(
			'post_parent'    => $post_id,
			'posts_per_page' => 1,
			'post_status'    => 'inherit',
			'post_type'      => 'attachment',
			'post_mime_type' => 'image',
		) );
		if ( $attachments && is_array( $attachments ) ) {
			$img_id = $attachments[0]->ID;
			$fullsize_img = wp_get_attachment_url( $img_id );
			$cropped_image = wp_get_attachment_image( $img_id , 'fullwidth-thumbnail' );
			echo '<figure class="lightbox-image"><a href="' . esc_url( $fullsize_img ) . '" class="lightbox-gallery">' . $cropped_image . '<span class="img-mask"></span></a></figure>';
		}
	}
}