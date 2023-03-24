<?php
add_action('admin_menu', 'af_p5_my_admin_menu');

function af_p5_my_admin_menu () {
    //parameters details
     //add_management_page( $page_title, $menu_title, $capability, $menu_slug, $function );
     //add a new setting page udner setting menu
  //add_management_page('Footer Text', 'Footer Text', 'manage_options', __FILE__, //'footer_text_admin_page');
  //add new menu and its sub menu
  //add_menu_page('Titre page option 1', 'Plugin4 Options', 'manage_options', 'menuparent', 'fct_option1');

  add_menu_page(
    'P5 option 1',
    'Plugin5 Settings',
    'manage_options',
    'af_p5_menuparent',
    'af_p5_settings_page1'
  );


  add_submenu_page( 'af_p5_menuparent',
  'P5 option 2',
  'Informations',
  'manage_options',
  'af_p5_menuenfant1',
  'af_p5_settings_page2');
}

function af_p5_settings_page1() {
    echo "<h2>" . __( 'Configuration des informations Leaflet', 'menu-test' ) . "</h2>";
    include_once('option1.php');
}

function af_p5_settings_page2() {
    include_once('option2.php');
}

function pl6_leaflet_shortcode() {
  $markers = [];
  for ($i = 1; $i <= get_option('af_p5_number_marqueur'); $i++) {
    $markers[] = 'let marker'.$i.' = L.marker(['.get_option('af_p5_m' . $i . '_long').', '.get_option('af_p5_m' . $i . '_lat').']).addTo(mymap);';
  }
  $markers_js = '';
  foreach ($markers as $marker) {
    $markers_js = $markers_js.$marker;
  }
  $map =
      '<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
   integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
   crossorigin=""/>
   <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
crossorigin=""></script>
         <div id="map" style="height: 500px;"></div>
        <script>
            var mymap = L.map(\'map\').setView(['.get_option('af_p5_center_map_long').', '.get_option('af_p5_center_map_lat').'], '.get_option('af_p5_map_zoom_level').');

            L.tileLayer(\'https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}\', {
    attribution: \'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>\',
    maxZoom: 18,
    id: \'mapbox/streets-v11\',
    tileSize: 512,
    zoomOffset: -1,
    accessToken: \'pk.eyJ1IjoiY2Fyb25pNjY1NCIsImEiOiJja3diMTF2MTMxN2NnMm5xbTJyNzQzNGI3In0.lcmpShXB8OlPUwjPp9uMNw\'
}).addTo(mymap);'.$markers_js.'
        </script>';
  return $map;
}

add_shortcode('af_leaflet', 'pl6_leaflet_shortcode');