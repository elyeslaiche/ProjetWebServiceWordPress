<?php
global $chk;
if (isset($_POST['save_changes'])) {
    save_changes();
}
if (isset($_POST['purge'])) {
    purge();
}
function save_changes()
{

}

function purge()
{

}

?>

<div class="wrap">
    <div id="icon-options-general" class="icon32"><br>
    </div>
    <h2>Spotify settings</h2>
    <?php if (isset($_POST['save_changes']) && $chk): ?>
        <div id="message" class="updated below-h2">
            <p>Content updated successfully</p>
        </div>
    <?php endif;
        if (isset($_POST['purge']) && $chk): ?>
        <div id="message" class="updated below-h2">
            <p>Database purged successfully</p>
        </div>
    <?php endif;?>
    <div class="metabox-holder">
        <div class="postbox">
            <form method="post" action="">
                <table class="form-table">
                    <tr>
                        <td>Name of database : <input type="text" name="center_map_long" placeholder="Name_Example"
                                   value="<?php echo get_option('name_of_database'); ?>" style="width:200px;"/></td>
                        <td>Expiration date (days) : <input type="text" name="center_map_lat" placeholder="7"
                                   value="<?php echo get_option('expiration_date'); ?>" style="width:200px;"/></td>
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
