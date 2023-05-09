<?php

require_once 'config.php';
require_once __DIR__ . '/spotify.php';

// Path to the SQLite database file
$conn = ABSPATH . 'wp-content/plugins/ProjetWebServiceWordPress/' . $dbname;

if (isset($_POST['delete_row'])) {
    delete_row($_POST['rowId'], $conn);
}
if (isset($_POST['update_row'])) {
    update_row($_POST['rowId'], $conn);
}

function get_rows($conn)
{
    $db = new SQLite3($conn);
    // Récupération des données de la table records
    $req1 = "SELECT rowid,* FROM records";
    $result = $db->query($req1);

    $expiration_date = $db->query("SELECT days_before_expiration FROM parameters")->fetchArray();
    while ($row = $result->fetchArray()) {
        echo "<tr>";
        if (round((strtotime(date(DATE_ATOM)) - strtotime($row['timestamp']))/(60*60*24)) > $expiration_date[0]) {
            echo "<td style='color:red'><b>" . $row['keyword'] . "</b></td>";
            echo "<td style='color:red'><b>" . $row['research_type'] . "</b></td>";
            echo "<td style='color:red'><b>" . $row['timestamp'] . "</b></td>";
            echo "<td><form method='POST'>
            <input type='hidden'  name='rowId' value='" . $row['id'] . "'/>
            <input type='submit'  name='delete_row' value='Delete Row' class='button-primary'/>
            <input type='submit'  name='update_row' value='Update Data' class='button-primary'/></form></td>";
        }
        else{
            echo "<td style='color:black'>" . $row['keyword'] . "</td>";
            echo "<td style='color:black'>" . $row['research_type'] . "</td>";
            echo "<td style='color:black'>" . $row['timestamp'] . "</td>";
        }

        echo "</tr>";
    }
    $db->close();
}

function delete_row($Id, $conn)
{
    $db = new SQLite3($conn);
    // Récupération des données de la table records
    $req1 = "DELETE FROM records WHERE id = '" . $Id . "'";
    $db->exec($req1);
    $db->close();
}

function update_row($Id, $conn){
    $db = new SQLite3($conn);
    // Récupération des données de la table records
    $req1 = "SELECT * FROM records WHERE id = '" . $Id . "'";
    $result = $db->query($req1);
    $row = $result->fetchArray();

    $req2 = "SELECT number_of_records FROM parameters";
    $result2 = $db->query($req2);

    $limit = $result2->fetchArray();

    $access_token = get_access_token();

    // Define the Spotify API search endpoint
    $search_endpoint = 'https://api.spotify.com/v1/search';

    // Define the search types
    $types = $row[2];

    // Define the options for the stream context to send the GET request to the search endpoint
    $search_options = array(
        'http' => array(
            'method' => 'GET',
            'header' => "Authorization: Bearer " . $access_token . "\r\n" .
            "Content-Type: application/json\r\n",
        ),
    );

    // Create the URL for the search endpoint with the query and types parameters
    $search_url = $search_endpoint . '?' . http_build_query(
        array(
            'q' => $row[1],
            'type' => $types,
            'limit' => $limit[0] 
        )
    );
    // Create the stream context with the options
    $search_context = stream_context_create($search_options);

    // Send the GET request to the Spotify API search endpoint and retrieve the response
    $search_response = file_get_contents($search_url, false, $search_context);

    //$req3 = "UPDATE records SET record = '" . $search_response . "' , timestamp = '".Date(DATE_ATOM)."', WHERE id = '". $Id . "'";
    $stmt = $db->prepare("UPDATE records SET record=:value1, timestamp=:value2 WHERE id=:value3");
    $stmt->bindValue(':value1', $search_response);
    $stmt->bindValue(':value2', Date(DATE_ATOM));
    $stmt->bindValue(':value3', $Id);
    $stmt->execute();

    $db->close();    
}



?>

<div class="wrap">
    <div id="icon-options-general" class="icon32"><br>
    </div>
    <h2>Spotify settings</h2>
    <div class="metabox-holder">
        <div class="postbox">
            <form method="post" action="">
                <table class="form-table">
                    <thead>
                        <tr>
                            <th>Keywords</th>
                            <th>Research_Type</th>
                            <th>Timestamp</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        $row = get_rows($conn);
                        // Fermeture de la connexion à la base de données
                        
                        ?>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>