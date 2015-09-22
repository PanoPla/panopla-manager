<img src="assets/logo.jpg" alt="logo" />

## PanoPla Manager

PanoPlaManager is a simple WordPress plugin for adding panos to your blog. PanoPla is a CMS for creating virtual tours, virtual and augmented reality environments, and sharable flat and spherical panos.

## Usage

PanoPlaManager uses shortcodes to embed panos on your site. You can create a short code like so:

```
[ppm pano=22 height=400 width=600]
```

There are 3 attributes you must supply to the shortcode.

* pano - The ID of the pano you want to embed. This is found in the URL on panopla.
* height -  How tall you want the embedded pano.
* width - How wide you want the embedded pano.

You need to supply these attributes for the pano to be embeded. All of the functionality that is built on PanoPla is brought with the embedded pano. You can access all of the controls, you expect.

## How does it work?

The shortcode is broken down by the handler function.

```php
function ppm_handler($atts = array(), $out = FALSE) {

    static $args = array(
      'pano' => '1',
      'height' => '400',
      'width' => '600'
    );

    if ( $out ) return $args;
    $args = shortcode_atts( $args, $atts, 'ppm' );

    $pano .= "<iframe id='ppm_viewer' height='" . $args['height'] .
             "' wight='" . $args['width'] . "' src='http://panopla.com/pano/"
             . $args['pano'] . "'></iframe>";

    return $pano;
}
```
The `iframe` that is returned is complete, and the pano is embedded in your site. The output is like this:

```html
<iframe id="ppm_viewer" height="400" width="600" src="http://panopla.com/pano/22"></iframe>
```

You can enjoy your panos on your own site now.

## Account

Q. Do you need a PanoPla account to use this plugin?

A. No, if you find a pano you like, you can embed it on your site.

## License

```
Copyright 2015 PanoPla

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

    http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
```
