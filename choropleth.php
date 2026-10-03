<?php
/**
 * Plugin Name:       Choropleth for Leaflet Map
 * Description:       Choropleth functions
 * Version:           1.0
 * Requires PHP:      8.2
 * Requires Plugins:  leaflet-map, extensions-leaflet-map
 * Author:            hupe13
 * License:           GPL v2 or later
 *
 * @package leafext-choropleth
 **/

// Direktzugriff auf diese Datei verhindern.
defined( 'ABSPATH' ) || die();

define( 'CHOROPLETH', __FILE__ );
define( 'CHOROPLETH_DIR', __DIR__ );
define( 'CHOROPLETH_URL', str_replace( WP_CONTENT_DIR, WP_CONTENT_URL, __DIR__ ) );

require_once __DIR__ . '/leafext/choropleth.php';
require_once __DIR__ . '/leafext/admin-choropleth.php';

/**
 * For translating
 */
function leafext_choropleth_load_textdomain() {
	load_plugin_textdomain( 'leaflet-choropleth', false, __DIR__ . '/lang' );
}
add_action( 'plugins_loaded', 'leafext_choropleth_load_textdomain' );

/**
 * For translating if both plugins (WP and Github) exist.
 */
function leafext_choropleth_extra_textdomain( $mofile, $domain ) {

	if ( 'leaflet-choropleth' === $domain ) {
		if ( file_exists( CHOROPLETH_DIR . '/lang/leaflet-choropleth-' . get_locale() . '.mo' ) ) {
			$mofile = CHOROPLETH_DIR . '/lang/leaflet-choropleth-' . get_locale() . '.mo';
		}
	}
	return $mofile;
}
add_filter( 'load_textdomain_mofile', 'leafext_choropleth_extra_textdomain', 10, 2 );
