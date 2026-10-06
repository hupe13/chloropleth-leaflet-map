<?php
/**
 * Functions for choropleth shortcode
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

// Parameter and Values
function leafext_choropleth_params() {
	$params = array(
		array( 'valueproperty', __( 'which property in the features to use', 'choropleth-leaflet-map' ), '', 'property' ),
		array( 'scale', __( 'a comma separated list of colors for scale - include as many as you like', 'choropleth-leaflet-map' ), 'white, red', '"white, red, blue"' ),
		array( 'fillopacity', __( 'opacity of the colors in scale', 'choropleth-leaflet-map' ), '0.8', '0.8' ),
		array( 'steps', __( 'number of breaks or steps in range', 'choropleth-leaflet-map' ), '5', '5' ),
		array( 'mode', __( 'q for quantile, e for equidistant, k for k-means', 'choropleth-leaflet-map' ), 'q', 'q' ),
		array( 'legend', __( 'show legend', 'choropleth-leaflet-map' ), true, '!legend' ),
	);
	return $params;
}

// Shortcode: [choropleth]
function leafext_choropleth_script( $atts ) {
	$text = '<script><!--';
	ob_start();
	?>/*<script>*/
	window.WPLeafletMapPlugin = window.WPLeafletMapPlugin || [];
	window.WPLeafletMapPlugin.push(function () {
		var map = window.WPLeafletMapPlugin.getCurrentMap();
		var att_valueProperty = <?php echo wp_json_encode( $atts['valueproperty'] ); ?>;
		var att_scale = <?php echo wp_json_encode( $atts['scale'] ); ?>.split(",");
		var att_steps = <?php echo wp_json_encode( $atts['steps'] ); ?>;
		var att_mode = <?php echo wp_json_encode( $atts['mode'] ); ?>;
		var att_legend = <?php echo wp_json_encode( (bool) $atts['legend'] ); ?>;
		var att_fillOpacity = <?php echo wp_json_encode( $atts['fillopacity'] ); ?>;
		console.log(att_valueProperty,att_scale,att_steps,att_mode,att_legend,att_fillOpacity);
		leafext_choropleth_js(map,att_valueProperty,att_scale,att_steps,att_mode,att_legend,att_fillOpacity);
	});
	<?php
	$javascript = ob_get_clean();
	$text      .= $javascript . '//-->' . "\n" . '</script>';
	return "\n" . $text . "\n";
}

function leafext_choropleth_function( $atts, $shortcode ) {
	$text = leafext_should_interpret_shortcode( $shortcode, $atts );
	if ( $text !== '' ) {
		return $text;
	} else {
		leafext_enqueue_choropleth();
		$params   = leafext_choropleth_params();
		$defaults = array();
		foreach ( $params as $param ) {
			$defaults[ $param[0] ] = $param[2];
		}
		// var_dump($params,$defaults);
		$options          = shortcode_atts( $defaults, leafext_clear_params_choro( $atts ) );
		$options['scale'] = str_replace( ' ', '', $options['scale'] );
		// var_dump($atts); wp_die("test");
		return leafext_choropleth_script( $options );
	}
}
add_shortcode( 'choropleth', 'leafext_choropleth_function' );

// Choropleth
function leafext_enqueue_choropleth() {
	wp_enqueue_script(
		'leaflet-choropleth',
		CHOROPLETH_URL . '/plugin/choropleth.js',
		array( 'wp_leaflet_map' ),
		'1',
		true
	);
	wp_enqueue_script(
		'choropleth_2',
		CHOROPLETH_URL . '/leafext/choropleth.js',
		array( 'leaflet-choropleth' ),
		'1',
		true
	);
	wp_enqueue_style(
		'choropleth_css',
		CHOROPLETH_URL . '/leafext/choropleth.min.css',
		array( 'leaflet_stylesheet' ),
		'1'
	);
}

// Interpretiere !parameter und parameter als false und true
function leafext_clear_params_choro( $atts ) {
	if ( is_array( $atts ) ) {
		foreach ( $atts as $attr => $value ) {
			if ( is_int( $attr ) ) {
				if ( strpos( $atts[ $attr ], '!' ) === false ) {
					$atts[ $atts[ $attr ] ] = true;
				} else {
					$atts[ substr( $atts[ $attr ], 1 ) ] = false;
				}
				unset( $atts[ $attr ] );
			} else {
				$atts[ $attr ] = esc_js( $value );
			}
		}
	}
	// var_dump($atts);
	return( $atts );
}