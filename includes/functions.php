<?php
add_action('admin_menu', 'admin_menu');

function admin_menu()
{
  //parameters details
  //add_management_page( $page_title, $menu_title, $capability, $menu_slug, $function );
  //add a new setting page under setting menu
  //add_management_page('Footer Text', 'Footer Text', 'manage_options', __FILE__, //'footer_text_admin_page');
  //add new menu and its sub menu
  //add_menu_page('Titre page option 1', 'Plugin4 Options', 'manage_options', 'menuparent', 'fct_option1');

  add_menu_page(
    'Paramètres généraux',
    'General Settings',
    'manage_options',
    'menuparent',
    'general_settings'
  );


  add_submenu_page(
    'menuparent',
    'Base de données',
    'Database',
    'manage_options',
    'menuenfant',
    'database'
  );
}

function general_settings()
{
  include_once('general_settings.php');
}

function database()
{
  include_once('display_database.php');
}

function pl6_leaflet_shortcode()
{
  $SearchBar = "
  <div class='jumbotron' id='jumbodiv'><input type='text' id='searchBar' name='SearchBar' placeholder='Search for an artist, song, album,...'class='SearchBar text-center'/>
  <button class='BtnSearch text-center' onclick='onclickSearchBTN()'>search</button></div>";
  return $SearchBar;
}

add_shortcode('Spotify_SearchBar', 'pl6_leaflet_shortcode');

?>
<html>

<head>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"
    integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
</head>
<style>
  .SearchBar {
    height: 30px;
    width: 50%;
    border-radius: 5px;
    border-width: 1px;
    margin-left: 21.5%;
    margin-bottom:2rem;
    border-color: #1db954;
    background-color: black;
    color: #1db954;
    text-align: center;
    align-items: center;
  }

  .jumbotron {
    border-radius: 10px;
    border-width: 1px;
    background-color:lightgray
  }

  .BtnSearch {
    height: 30px;
    border-radius: 5px;
    border-width: 1px;
    border-color: #1db954;
    background-color: black;
    color: #1db954;
    text-align: center;
  }

  #resultdiv{
    width:75%;
    margin-left:auto;
    margin-right:auto;
  }

  pre{
    background-color:lightgray;
    border-color:lightgray;
    text-align: justify;
  }
</style>

<script>
  function onclickSearchBTN() {
    var dataString = { 'value': $('#searchBar').val() };
    $.ajax({
      type: 'GET',
      url: 'http://localhost/WebServicesWordpress/wp-content/plugins/ProjetWebServiceWordPress/includes/spotify.php',
      data: dataString,
      success: function (response) {

        var resultdiv = document.getElementById('resultdiv');

        // Check if the resultdiv element exists
        if (resultdiv) {
          // Remove the resultdiv element from the document
          resultdiv.parentNode.removeChild(resultdiv);
        }
        $("#jumbodiv").append("<div id='resultdiv'><pre>" + response +"</div>");

      },
    });
  }
</script>

</html>