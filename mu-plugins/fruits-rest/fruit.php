<?php
/**
 * @package fruits-core
 */

namespace Fruits\Core\Rest;

/**
 * Fetch all fruits
 *
 * @return array|WP_REST_Response Response
 */
function fruits_all() {
	global $wpdb;

	$language = '%[:' . qtranxf_getLanguage() . ']%';

	$results = $wpdb->get_results( $wpdb->prepare( "
		SELECT
           `t`.`post_title` AS `name`,
           `t`.`post_name` AS `slug`,
           GROUP_CONCAT(`t4`.`name`) AS `categories`,
           GROUP_CONCAT(`t4`.`slug`) AS `category_slugs`,
           `t5`.`meta_value` AS `taste`,
           `t7`.`meta_value` AS `thumbnail`
        FROM
           `{$wpdb->posts}` `t`
        LEFT JOIN `{$wpdb->term_relationships}` `t2`
            ON `t2`.`object_id` = `t`.`ID`
        LEFT JOIN `{$wpdb->term_taxonomy}` `t3`
            ON `t3`.`term_taxonomy_id` = `t2`.`term_taxonomy_id`
        LEFT JOIN `{$wpdb->terms}` `t4`
            ON `t4`.`term_id` = `t3`.`term_id`
        LEFT JOIN `{$wpdb->postmeta}` `t5`
            ON `t5`.`meta_key` = '_taste' AND `t5`.`post_id` = `t`.`ID`
        LEFT JOIN `{$wpdb->postmeta}` `t6`
        	ON `t6`.`meta_key` = '_thumbnail_id' AND `t6`.`post_id` = `t`.`ID`
        LEFT JOIN `{$wpdb->postmeta}` `t7`
        	ON `t7`.`meta_key` = '_wp_attached_file' AND `t7`.`post_id` = `t6`.`meta_value`
        WHERE
       		`t`.`post_type` = 'fruit' AND `t`.`post_status` = 'publish' AND
       		(`post_title` LIKE %s OR `post_title` NOT LIKE %s)
        GROUP BY `t`.`ID`
	", $language, '%[:]' ) );

	foreach ( $results as $k => $result ) {
		$results[ $k ]->name = qtranxf_translate( $result->name );
		$results[ $k ]->taste = qtranxf_translate( $result->taste );
	}

	return [ 'data' => $results ];
}

/**
 * Fetch all fruits by category
 *
 * @param WP_REST_Request $data Request data
 *
 * @return array|WP_REST_Response Response
 */
function fruits_all_by_category( \WP_REST_Request $data ) {
	global $wpdb;

	$category = (string) $data['category'];
	$language = '%[:' . qtranxf_getLanguage() . ']%';

	$results = $wpdb->get_results( $wpdb->prepare( "
		SELECT
			`t`.`post_title` AS `name`,
			`t`.`post_name` AS `slug`,
			GROUP_CONCAT(`t4`.`name`) AS `categories`,
			GROUP_CONCAT(`t4`.`slug`) AS `category_slugs`,
			`t5`.`meta_value` AS `taste`,
			`t7`.`meta_value` AS `thumbnail`
		FROM
			`{$wpdb->terms}` `rt`
		LEFT JOIN `{$wpdb->term_taxonomy}` `rt1`
			ON `rt1`.`term_id` = `rt`.`term_id`
		LEFT JOIN `{$wpdb->term_relationships}` `rt2`
			ON `rt2`.`term_taxonomy_id` = `rt1`.`term_taxonomy_id`
		LEFT JOIN `{$wpdb->posts}` `t`
			ON `rt2`.`object_id` = `t`.`ID`
		LEFT JOIN `{$wpdb->term_relationships}` `t2`
			ON `t2`.`object_id` = `t`.`ID`
		LEFT JOIN `{$wpdb->term_taxonomy}` `t3`
			ON `t3`.`term_taxonomy_id` = `t2`.`term_taxonomy_id`
		LEFT JOIN `{$wpdb->terms}` `t4`
			ON `t4`.`term_id` = `t3`.`term_id`
		LEFT JOIN `{$wpdb->postmeta}` `t5`
			ON `t5`.`meta_key` = '_taste' and `t5`.`post_id` = `t`.`ID`
        LEFT JOIN `{$wpdb->postmeta}` `t6`
        	ON `t6`.`meta_key` = '_thumbnail_id' AND `t6`.`post_id` = `t`.`ID`
        LEFT JOIN `{$wpdb->postmeta}` `t7`
        	ON `t7`.`meta_key` = '_wp_attached_file' AND `t7`.`post_id` = `t6`.`meta_value`
		WHERE
			`t`.`post_type` = 'fruit' AND `t`.`post_status` = 'publish' AND `rt`.`name` = %s AND
			(`post_title` LIKE %s OR `post_title` NOT LIKE %s)
		GROUP BY `t`.`ID`	
	", $category, $language, '%[:]' ) );

	foreach ( $results as $k => $result ) {
		$results[ $k ]->name = qtranxf_translate( $result->name );
		$results[ $k ]->taste = qtranxf_translate( $result->taste );
	}

	return [ 'data' => $results ];
}

/**
 * Fetch single fruit by slug
 *
 * @param WP_REST_Request $data Request data
 *
 * @return array|WP_REST_Response Response
 */
function fruits_single_by_slug( \WP_REST_Request $data ) {
	global $wpdb;

	$slug = (string) $data['slug'];
	$language = '%[:' . qtranxf_getLanguage() . ']%';

	$result = $wpdb->get_row( $wpdb->prepare( "
		SELECT
			`t`.`post_title` AS `name`,
			`t`.`ID` AS `id`,
	        GROUP_CONCAT(`t4`.`name`) AS `categories`,
    	    GROUP_CONCAT(`t4`.`slug`) AS `category_slugs`,
			`t5`.`meta_value` AS `taste`,
			`t7`.`meta_value` AS `thumbnail`
		FROM
			`{$wpdb->posts}` `t`
        LEFT JOIN `{$wpdb->term_relationships}` `t2`
            ON `t2`.`object_id` = `t`.`ID`
        LEFT JOIN `{$wpdb->term_taxonomy}` `t3`
            ON `t3`.`term_taxonomy_id` = `t2`.`term_taxonomy_id`
        LEFT JOIN `{$wpdb->terms}` `t4`
            ON `t4`.`term_id` = `t3`.`term_id`
        LEFT JOIN `{$wpdb->postmeta}` `t5`
            ON `t5`.`meta_key` = '_taste' AND `t5`.`post_id` = `t`.`ID`
        LEFT JOIN `{$wpdb->postmeta}` `t6`
        	ON `t6`.`meta_key` = '_thumbnail_id' AND `t6`.`post_id` = `t`.`ID`
        LEFT JOIN `{$wpdb->postmeta}` `t7`
        	ON `t7`.`meta_key` = '_wp_attached_file' AND `t7`.`post_id` = `t6`.`meta_value`
		WHERE
			`t`.`post_type` = 'fruit' AND `t`.`post_status` = 'publish' AND `t`.`post_name` = %s AND
			(`post_title` LIKE %s OR `post_title` NOT LIKE %s)
	", $slug, $language, '%[:]' ) );

	if ( ! $result ) {
		return new \WP_REST_Response( [
			'response' => 'fruit.not_found',
			'status' => 404
		], 404 );
	}

	$colors = carbon_get_post_meta( $result->id, 'colors', 'complex' );

	$colors = array_map( function( $o ) {
		return [ 'color' => $o['color'], 'name' => qtranxf_translate( $o['name'] ) ];
	}, $colors );

	return [
		'name' => qtranxf_translate($result->name),
		'categories' => $result->categories,
		'category_slugs' => $result->category_slugs,
		'taste' => qtranxf_translate($result->taste),
		'thumbnail' => $result->thumbnail,
		'colors' => $colors
	];
}

add_action( 'rest_api_init', function() {
	register_rest_route( 'v1', '/fruits', [
		'methods' => 'GET',
		'callback' => 'Fruits\Core\Rest\fruits_all',
	]);

	register_rest_route( 'v1', '/fruits/category/(?<category>[a-zA-Z0-9]+)', [
		'methods' => 'GET',
		'callback' => 'Fruits\Core\Rest\fruits_all_by_category',
	]);

	register_rest_route( 'v1', '/fruits/(?<slug>[a-zA-Z0-9]+)', [
		'methods' => 'GET',
		'callback' => 'Fruits\Core\Rest\fruits_single_by_slug',
	]);
} );
