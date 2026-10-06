<?php
/**
 * Admin functions for choropleth shortcode
 *
 * @package choropleth-leaflet-map
 */

/*
 * Doku choropleth deutsch https://doc.arcgis.com/de/insights/latest/create/choropleth-maps.htm
 * https://gisgeography.com/choropleth-maps-data-classification/
 */

// mode: q for quantile, e for equidistant, k for k-means
// quantile maps try to arrange groups so they have the same quantity.
// equidistant: divide the classes into equal groups.
// k-means: each standard deviation becomes a class (?)

// Direktzugriff auf diese Datei verhindern.
defined( 'ABSPATH' ) || die();

function leafext_choropleth_help() {
	$codestyle = ' class="language-coffeescript"';
	$text  = '<h2>Shortcode</h2>';
	$text .= '<p>' . wp_sprintf(
		/* translators: %s is ashortcode name. */
		__( 'The shortcode has changed!! Do not forget %s, if you want get a tooltip on mouse over.', 'choropleth-leaflet-map' ),
		'<code ' . $codestyle . '>hoverlap</code>'
	) . '</p>';
	$text .= '<p><pre' . $codestyle . '><code' . $codestyle . '>&#091;leaflet-map fitbounds ....]' . "\n";
	$text .= '&#091;leaflet-geojson src=https://domain.tld/path/to/file.geojson]Property1 {property1}&lt;br>{property2} Property2[/leaflet-geojson]
&#091;choropleth valueProperty="property1" scale="white, red" steps=5 mode=e legend fillopacity=0.8]
&#091;hoverlap]
&#091;zoomhomemap]';
	$text .= '</code></pre></p>';

	$text .= '<h2>' . __( 'Popup Content', 'choropleth-leaflet-map' ) . '</h2><p>';
	$text .= '</p><p>' . wp_sprintf(
		/* translators: %s is ashortcode name. */
		__(
			'Specify the popup content in %s shortcode: To add feature properties to the popups, use the inner content and curly brackets to substitute the values:',
			'choropleth-leaflet-map'
		),
		'<code ' . $codestyle . '>leaflet-geojson</code>'
	);
	$text .= '<pre' . $codestyle . '><code' . $codestyle . '>&#91;leaflet-geojson ...]Field A = {field_a}[/leaflet-geojson]';
	$text .= '</code></pre>'
	. '</p>';
	$text .= wp_sprintf(
		/* translators: %s is an example code. */
		__( 'You can specify %s as you like.', 'choropleth-leaflet-map' ),
		'<code ' . $codestyle . '>Property1 {property1}&lt;br>{property2} Property2</code>'
	);

	$text   .= '<h2>' . __( 'Options', 'choropleth-leaflet-map' ) . '</h2>';
	$options = leafext_choropleth_params();
	$new     = array();
	$new[]   = array(
		'param'   => '<strong>Option</strong>',
		'default' => '<strong>' . __( 'Default', 'choropleth-leaflet-map' ) . '</strong>',
		'desc'    => '<strong>' . __( 'Description', 'choropleth-leaflet-map' ) . '</strong>',
		'example' => '<strong>' . __( 'Example', 'choropleth-leaflet-map' ) . '</strong>',
	);
	foreach ( $options as $option ) {
		$new[] = array(
			'param'   => $option[0],
			'default' => $option[2],
			'desc'    => $option[1],
			'example' => $option[3],
		);
	}
	$text .= leafext_html_table( $new );

	$text .= '<h3>mode</h3>
  <p><ul>
  <li> ' . __( 'quantile maps try to arrange groups so they have the same quantity.', 'choropleth-leaflet-map' ) . '</li>
  <li> ' . __( 'equidistant: divide the classes into equal groups.', 'choropleth-leaflet-map' ) . '</li>
  <li> ' . __( 'k-means: each standard deviation becomes a class.', 'choropleth-leaflet-map' ) . '</li>
  </ul></p>';

	return $text;
}
