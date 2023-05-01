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
  $SearchBar = "<div class='jumbotron' style='background-color:;'><input type='text' name='SearchBar' placeholder='Search for an artist, song, album,...'
   class='SearchBar text-center'/></td>
  <button class='BtnSearch text-center'>search</button></div>";
  return $SearchBar;
}

add_shortcode('Spotify_SearchBar', 'pl6_leaflet_shortcode');

?>
<html>
  <head>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  </head>
  <style>
      .SearchBar{
        height:30px;
        width:50%;
        border-radius:5px;
        border-width:1px;
        margin-left:21.5%;
        border-color:#1db954;
        background-color:black;
        color:#1db954;
        text-align: center;
        align-items:center;
      }

      .BtnSearch{
        height:30px;
        border-radius:5px;
        border-width:1px;
        border-color:#1db954;
        background-color:black;
        color:#1db954;
        text-align: center;
      }
  </style>
</html>

