<?php

require_once 'config.php';

// Path to the SQLite database file
$conn = ABSPATH . 'wp-content/plugins/ProjetWebServiceWordPress/' . $dbname;

if (isset($_POST['delete_row'])) {
    delete_row($_POST['rowId'], $conn);
}

function get_rows($conn)
{
    $db = new SQLite3($conn);
    // Récupération des données de la table records
    $req1 = "SELECT rowid,* FROM records";
    $result = $db->query($req1);
    
    while ($row = $result->fetchArray()) {
        echo "<tr>";
        echo "<td>" . $row['keyword'] . "</td>";
        echo "<td>" . $row['research_type'] . "</td>";
        echo "<td>" . $row['timestamp'] . "</td>";
        echo "<td><form method='POST'>
        <input type='hidden'  name='rowId' value='".$row['id']."'/>
        <input type='submit'  name='delete_row' value='Delete Row' class='button-primary'/></form></td>";
        echo "</tr>";
    }
    $db->close();
}

function delete_row($Id, $conn)
{
    $db = new SQLite3($conn);
    // Récupération des données de la table records
    $req1 = "DELETE FROM records WHERE id = '" . $Id . "'";
    $db->query($req1);
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