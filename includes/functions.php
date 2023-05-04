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
    'Spotify settings',
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

function spotify_shortcode()
{
  $SearchBar = "
  <div class='jumbotron' id='jumbodiv'><input type='text' id='searchBar' name='SearchBar' placeholder='Search for an artist, song, album,...'class='SearchBar text-center'/>
  <button class='BtnSearch text-center' onclick='onclickSearchBTN()'>search</button></div>";
  return $SearchBar;
}

add_shortcode('Spotify_SearchBar', 'spotify_shortcode');
wp_enqueue_style( 'spotify-shortcode-styles', plugins_url( 'searchbar.css', __FILE__ ) );

?>
<html>

<head>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"
    integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
</head>

<script>
  function onclickSearchBTN() {
    var dataString = { 'value': $('#searchBar').val() };
    $.ajax({
      type: 'GET',
      url: '<?php echo plugins_url( 'spotify.php', __FILE__ )?>',
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