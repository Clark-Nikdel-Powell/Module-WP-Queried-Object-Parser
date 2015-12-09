<?php
/**
 * cnp_parse_queried_object
 *
 * @version 0.3 - Dev release.
 *
 * Provides shorthand access to a standard description of the WordPress object being requested.
 */
function cnp_parse_queried_object() {

	$object = get_queried_object();

	if ( isset( $object->taxonomy ) ) {
		return cnp_queried_object( 'taxonomy', $object->taxonomy, $object->slug, $object->term_id );
	}

	global $post;
	return cnp_queried_object( 'post_type', $post->post_type, $post->post_name, $post->ID );

}

/**
 * @param string $type
 * @param string $object
 * @param string $slug
 * @param int $ID
 *
 * @return object
 */
function cnp_queried_object( $type = '', $object = '', $slug = '', $ID = 0 ) {

	$queried_array = [
		'type'      => $type,
		'wp_object' => $object,
		'slug'      => $slug,
		'ID'        => $ID
	];

	$queried_object = apply_filters( 'cnp_queried_object_filter', (object) $queried_array );

	return $queried_object;

}
