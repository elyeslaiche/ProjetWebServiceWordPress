<?php
require_once 'config.php';

// Path to the SQLite database file
$conn = ABSPATH . 'wp-content/plugins/ProjetWebServiceWordPress/'.$dbname;

// Connexion à la base de données SQLite
$db = new SQLite3($conn);

// Récupération des données de la table records
$req1 = "SELECT * FROM records";
$result = $db->query($req1);

// Affichage des données sous forme de tableau HTML
echo '<table>';
echo '<thead><tr><th>ID</th><th>Keyword</th><th>Research Type</th><th>Record</th><th>Timestamp</th></tr></thead>';
echo '<tbody>';
while ($row = $result->fetchArray()) {
    echo '<tr>';
    echo '<td>' . $row['id'] . '</td>';
    echo '<td>' . $row['keyword'] . '</td>';
    echo '<td>' . $row['research_type'] . '</td>';
    echo '<td>' . $row['record'] . '</td>';
    echo '<td>' . $row['timestamp'] . '</td>';
    echo '</tr>';
}
echo '</tbody>';
echo '</table>';

// Fermeture de la connexion à la base de données
$db->close();
?>


