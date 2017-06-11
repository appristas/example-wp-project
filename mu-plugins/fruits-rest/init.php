<?php
/**
 * @package fruits-core
 */

namespace Fruits\Core\Rest;

/**
 * Initialize namespaces
 *
 * @return array Empty array
 */
function remove_index() {
	return [];
}

/**
 * Remove WP core endpoints
 *
 * @param array $routes All routes
 *
 * @return array Filtered routes
 */
function remove_endpoints( $routes ) {
	foreach ( array_keys( $routes ) as $endpoint ) {
		if ( 0 === strpos( $endpoint, '/wp/v2' ) ) {
			unset( $routes[ $endpoint ] );
		}
	}
	return $routes;
}

/**
 * Set language based on accept language header
 *
 * @param mixed $result Result
 * @param WP_REST_Server $server REST Server instance
 * @param WP_REST_Request $request REST Request instance
 *
 * @return null
 */
function set_language_from_header( $result, $server, $request ) {
	global $q_config;

	$language = $request->get_header( 'accept_language' );
	if ( ! isset( $q_config['locale'][ $language ] ) ) {
		$language = $q_config['default_language'];
	}

	$q_config['language'] = $language;

	return null;
}

add_filter( 'rest_pre_dispatch', 'Fruits\Core\Rest\set_language_from_header', 15, 3 );
add_filter( 'rest_index', 'Fruits\Core\Rest\remove_index', 100, 3 );
add_filter( 'rest_endpoints', 'Fruits\Core\Rest\remove_endpoints', 100, 3 );
