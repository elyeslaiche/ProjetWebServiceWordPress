<?php
require_once 'config.php';

// Path to the SQLite database file
$conn = ABSPATH . 'wp-content/plugins/ProjetWebServiceWordPress/'.$dbname;

// Connexion à la base de données SQLite
$db = new SQLite3($conn);

// Récupération des données de la table records
$req1 = "SELECT * FROM records";
$result = $db->query($req1);

// Fermeture de la connexion à la base de données
//$db->close();
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
                    while ($row = $result->fetchArray()) {
                        echo "<tr>";
                        echo "<td>" . $row['keyword'] . "</td>";
                        echo "<td>" . $row['research_type'] . "</td>";
                        echo "<td>" . $row['timestamp'] . "</td>";
                        echo "</tr>";
                    }
                    // Fermeture de la connexion à la base de données
                    $db->close();
                    ?>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>

