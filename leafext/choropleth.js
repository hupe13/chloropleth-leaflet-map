/**
 * Javascript function for Shortcode choropleth
 *
 * @package choropleth-leaflet-map
 */

/**
 * Create Javascript code for choropleth.
 */

function leafext_choropleth_js(map,att_valueProperty,att_scale,att_steps,att_mode,att_legend,att_fillOpacity) {
	map.eachLayer(
		function (layer) {
			// console.log(layer.options.type);
			if (layer.options.type == "json" ) {
				layer.on(
					"ready",
					function (layer) {
						// console.log(layer.target.json);
						map.removeLayer( layer );
						choropleth = L.choropleth(
							layer.sourceTarget.json,
							{
								valueProperty: att_valueProperty,
								scale: att_scale,
								steps: att_steps,
								mode: att_mode,
								style: {
									color: "#fff",
									weight: 2,
									fillOpacity: att_fillOpacity
								},
								onEachFeature: function (feature, layer) {
									layer.on(
										"mouseover",
										function (e) {
											e.target.setStyle(
												{
													weight: 4,
													color: "#666",
												}
											);
											e.target.bringToFront();
										}
									),
									layer.on(
										"mouseout",
										function (e) {
											e.target.setStyle(
												{
													weight: 2,
													color: "#fff",
												}
											);
										}
									)
								}
							}
						); // choropleth
						choropleth.addTo( map );

						// Add legend (don't forget to add the CSS from index.html)
						if (att_legend) {
							var legend   = L.control( { position: 'bottomright' } );
							legend.onAdd = function (map) {
								var div    = L.DomUtil.create( 'div', 'info legend' );
								var limits = choropleth.options.limits;
								var colors = choropleth.options.colors;
								var labels = [];
								// Add min & max
								div.innerHTML  = '<div class="labels"><div class="min">' + limits[0] + '</div> \
								<div class="max">' + limits[limits.length - 1] + '</div></div>';
								limits.forEach(
									function (limit, index) {
										labels.push( '<li style="background-color: ' + colors[index] + '; opacity: ' + att_fillOpacity + ';"></li>' );
									}
								)
								div.innerHTML += '<ul>' + labels.join( '' ) + '</ul>';
								return div;
							}
							legend.addTo( map );
						}

					}
				); // on ready
			}; // if
		}
	); // map.eachLayer
}
