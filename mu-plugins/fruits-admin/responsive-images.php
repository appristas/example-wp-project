<?php
/**
 * @package fruits-core
 */

namespace Fruits\Core\Admin;

/**
 * Remove size attributes from HTML content
 *
 * @param string $html HTML content
 *
 * @return string HTML content
 */
function remove_size_attributes( $html ) {
    $html = preg_replace( '/(width|height)="\d*"\s/', '', $html );
    return $html;
}

add_filter( 'post_thumbnail_html', 'Fruits\Core\Admin\remove_size_attributes', 10 );
add_filter( 'image_send_to_editor', 'Fruits\Core\Admin\remove_size_attributes', 10 );