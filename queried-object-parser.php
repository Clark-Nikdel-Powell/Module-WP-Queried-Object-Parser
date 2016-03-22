<?php
/**
 * cnp_parse_queried_object
 *
 * @version 0.3.0 - Dev release.
 *
 * Provides shorthand access to a standard description of the WordPress object being requested.
 */
function cnp_parse_queried_object() {

	// Set up variables so we don't get an undefined index notice
	$args = [ ];

	// Get the queried object
	$object = get_queried_object();

	$view = '';
	if ( is_archive() ) {
		$view = 'archive';
	}
	if ( is_singular() ) {
		$view = 'singular';
	}

	// 404 & Search come first for a reason: they're easy to determine. Running them after the $post check might
	// return information about that $post rather than the 404 or Search pages.
	if ( is_404() ) {

		$args = [
			'type'   => '404',
			'object' => '404',
			'title'  => 'Page Not Found',
			'slug'   => '404',
			'ID'     => 0,
			'view'   => ''
		];

		return cnp_queried_object( $args );
	}

	if ( is_search() ) {

		$args = [
			'type'   => 'search',
			'object' => 'search',
			'title'  => 'Search Results',
			'slug'   => 'search',
			'ID'     => 0,
			'view'   => ''
		];

		return cnp_queried_object( $args );
	}

	// Post Type Object: comes up when you're viewing a post type archive. NOTE: can be tripped up if you have a
	// post with a slug identical to the post type name or rewrite slug.
	if ( isset( $object->labels ) ) {

		$args = [
			'type'   => 'post_type',
			'object' => $object->name,
			'title'  => $object->label,
			'slug'   => '',
			'ID'     => 0,
			'view'   => $view
		];

		return cnp_queried_object( $args );
	}

	// Taxonomy: viewing a taxonomy term
	if ( isset( $object->taxonomy ) ) {

		$args = [
			'type'   => 'taxonomy',
			'object' => $object->taxonomy,
			'title'  => $object->name,
			'slug'   => $object->slug,
			'ID'     => $object->term_id,
			'view'   => $view
		];

		return cnp_queried_object( $args );
	}

	// Post Objects
	global $post;
	if ( ! empty( $post ) ) {

		$args = [
			'type'   => 'post_type',
			'object' => $post->post_type,
			'title'  => $post->post_title,
			'slug'   => $post->post_name,
			'ID'     => $post->ID,
			'view'   => $view
		];

		return cnp_queried_object( $args );
	}
}

/**
 * @param string $type
 * @param string $object
 * @param string $slug
 * @param int $ID
 *
 * @return object
 */
function cnp_queried_object( $args = [ ] ) {

	$queried_array = [
		'type'      => $args['type'],
		'wp_object' => $args['object'],
		'title'     => $args['title'],
		'slug'      => $args['slug'],
		'ID'        => $args['ID'],
		'view'      => $args['view']
	];

	$queried_object = apply_filters( 'cnp_queried_object_filter', (object) $queried_array );

	return $queried_object;

}
