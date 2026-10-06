# Choropleth for Leaflet Map

## Description

Code for using the Choropleth plugin for Leaflet (color scale based on value) in WordPress: <a href="https://github.com/timwis/leaflet-choropleth">https://github.com/timwis/leaflet-choropleth</a>.

## XSS and why excluded

While fixing a XSS vulnerability in this shortcode, I discovered a bug that has been there for at least two years. For that reason, and since no one has complained, I decided to remove that part from <a href="https://wordpress.org/plugins/extensions-leaflet-map/">Extensions for Leaflet Map</a>.

This plugin needs Extensions for Leaflet Map version > 5.4 or its Github version > 5.4-260808.

### Shortcode

The shortcode has changed!! Do not forget <code>hoverlap</code>, if you want get a tooltip on mouse over.

    [leaflet-map fitbounds ....]
    [leaflet-geojson src=https://domain.tld/path/to/file.geojson]Property1 {property1}<br>{property2} Property2[/leaflet-geojson]
    [choropleth valueProperty="property1" scale="white, red" steps=5 mode=e legend fillopacity=0.8]
    [hoverlap]
    [zoomhomemap]

### Popup Content

Specify the popup content in <code>leaflet-geojson</code> shortcode: To add feature properties to the popups, use the inner content and curly brackets to substitute the values:

You can specify `Property1 {property1}<br>{property2} Property2` as you like.

    [leaflet-geojson ...]Field A = {field_a}[/leaflet-geojson]

### Options

<figure class="wp-block-table aligncenter is-style-stripes"><table border="1"><tr><td style="border:1px solid #195b7a"><strong>Option</strong></td><td style="border:1px solid #195b7a"><strong>Default</strong></td><td style="border:1px solid #195b7a"><strong>Description</strong></td><td style="border:1px solid #195b7a"><strong>Example</strong></td></tr>
<tr><td style="border:1px solid #195b7a">valueproperty</td><td style="border:1px solid #195b7a"></td><td style="border:1px solid #195b7a">which property in the features to use</td><td style="border:1px solid #195b7a">property</td></tr>
<tr><td style="border:1px solid #195b7a">scale</td><td style="border:1px solid #195b7a">white, red</td><td style="border:1px solid #195b7a">a comma separated list of colors for scale - include as many as you like</td><td style="border:1px solid #195b7a">"white, red, blue"</td></tr>
<tr><td style="border:1px solid #195b7a">fillopacity</td><td style="border:1px solid #195b7a">0.8</td><td style="border:1px solid #195b7a">opacity of the colors in scale</td><td style="border:1px solid #195b7a">0.8</td></tr>
<tr><td style="border:1px solid #195b7a">steps</td><td style="border:1px solid #195b7a">5</td><td style="border:1px solid #195b7a">number of breaks or steps in range</td><td style="border:1px solid #195b7a">5</td></tr>
<tr><td style="border:1px solid #195b7a">mode</td><td style="border:1px solid #195b7a">q</td><td style="border:1px solid #195b7a">q for quantile, e for equidistant, k for k-means</td><td style="border:1px solid #195b7a">q</td></tr>
<tr><td style="border:1px solid #195b7a">legend</td><td style="border:1px solid #195b7a">1</td><td style="border:1px solid #195b7a">show legend</td><td style="border:1px solid #195b7a">!legend</td></tr>
</table></figure></div>

### mode

*   quantile maps try to arrange groups so they have the same quantity.
*   equidistant: divide the classes into equal groups.
*   k-means: each standard deviation becomes a class.

## Installation

* First you need to install and configure the plugins <a href="https://wordpress.org/plugins/leaflet-map/">Leaflet Map</a> and <a href="https://wordpress.org/plugins/extensions-leaflet-map/">Extensions for Leaflet Map</a>.
* Download the <a href=".zip">zip file</a> and <a href="https://wordpress.org/support/article/managing-plugins/#manual-upload-via-wordpress-admin">upload it via WordPress Admin</a>.
* Activate the plugin.
* Go to Settings - Leaflet Map - Extensions for Leaflet Map - Choropleth Map and get documentation and settings options.
* Watch the repository to get updates.

## Example

<a href="https://leafext.de/extra/choropleth/">How to include Leaflet plugin Leaflet Choropleth</a>

