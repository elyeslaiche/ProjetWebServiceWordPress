<?php
global $chk;
if (isset($_POST['create_database'])) {
    create_database();
}
if (isset($_POST['save_changes'])) {
    save_changes();
}
if (isset($_POST['purge'])) {
    purge();
}

function create_database()
{
    require_once 'config.php';

    // Path to the SQLite database file
    $conn = ABSPATH . 'wp-content/plugins/ProjetWebServiceWordPress/'.$dbname;

    // Create the SQLite database file
    try
    {
        $db = new SQLite3($conn);
    }
    catch(PDOException $pe)
    {
        //Fonction DIE() identique à EXIT()
        die("<br>Erreur de connexion sur $dbname" . $pe->getMessage());
    }

    // Create a table in the database
    $req1 = "
            CREATE TABLE IF NOT EXISTS parameters (
                days_before_expiration INTEGER DEFAULT NULL,
                number_of_records INTEGER DEFAULT NULL
                );
            ";

    $req2 = "
            CREATE TABLE IF NOT EXISTS records (
                id INT AUTO_INCREMENT PRIMARY KEY,
                keyword VARCHAR(255) NOT NULL,
                research_type VARCHAR(255) NOT NULL,
                record VARCHAR NOT NULL,
                timestamp TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
                );
            ";

    $db->exec($req1);
    $db->exec($req2);

    // Close the database connection
    $db->close();
}

function save_changes()
{
    $expiration = $_POST['expiration'];
    $records = $_POST['records'];
    global $chk;
    require_once 'config.php';

    // Path to the SQLite database file
    $conn = ABSPATH . 'wp-content/plugins/ProjetWebServiceWordPress/'.$dbname;

    try
    {
        $db = new SQLite3($conn);
    }
    catch(PDOException $pe)
    {
        //Fonction DIE() identique à EXIT()
        die("<br>Erreur de connexion sur $dbname" . $pe->getMessage());
    }

    // Prepare the SQL query to check if the row exists in the database
    $req1 = "SELECT COUNT(*) FROM parameters";
    $result = $db->querySingle($req1);

    if($result == 1)
    {
        // Prepare the SQL query to insert into the parameters table
        $req2 = 'UPDATE parameters SET days_before_expiration = "'.$expiration.'",number_of_records = "'.$records.'"'
            .'WHERE rowid = 1;';

        // Execute the SQL query
        $db->exec($req2);
    }
    else
    {
        // Prepare the SQL query to update the parameters table
        $req3 = 'INSERT INTO parameters (days_before_expiration,number_of_records)'
            .'VALUES ("'.$expiration.'","'.$records.'");';

        // Execute the SQL query
        $db->exec($req3);
    }


    // Close the database connection
    $db->close();

    if (get_option('expiration_date') != trim($expiration)) {
        $chk = update_option('expiration_date', trim($expiration));
    }
    if (get_option('number_of_records') != trim($records)) {
        $chk = update_option('number_of_records', trim($records));
    }
}

function purge()
{

}
?>

<div class="wrap">
    <div id="icon-options-general" class="icon32"><br>
    </div>
    <h2>Spotify settings</h2>
    <?php if (isset($_POST['create_database'])): ?>
        <div id="message" class="updated below-h2">
            <p>Database created successfully</p>
        </div>
    <?php endif;
        if (isset($_POST['save_changes']) && $chk): ?>
        <div id="message" class="updated below-h2">
            <p>Content updated successfully</p>
        </div>
    <?php endif;
        if (isset($_POST['purge'])): ?>
        <div id="message" class="updated below-h2">
            <p>Database purged successfully</p>
        </div>
    <?php endif;?>
    <div class="metabox-holder">
        <div class="postbox">
            <form method="post" action="">
                <table class="form-table">
                    <tr>
                        <td><input type="submit" name="create_database" value="Create Database<?php echo get_option('database_created'); ?>" class="button-primary"/></td>
                        <td>Number of days before expiration : <input type="number" placeholder="7" name="expiration"
                                   value="<?php echo get_option('expiration_date'); ?>" style="width:200px;"/></td>
                        <td>Maximum number of records : <input type="number" placeholder="10" name="records"
                                   value="<?php echo get_option('number_of_records'); ?>" style="width:200px;"/></td>
                        <td><input type="submit" name="purge" value="Purge Database" class="button-primary"/></td>
                    </tr>
                </table>
                <br/>
                <table class="form-table">
                    <tr>
                        <td style="padding-top:10px;  padding-bottom:10px;">
                            <input type="submit" name="save_changes" value="Save changes" class="button-primary"/>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>
