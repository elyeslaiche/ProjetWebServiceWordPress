<?php
global $chk;
if (isset($_POST['wphw_submit'])) {
  af_p5_wphw_opt();
}
function af_p5_wphw_opt()
{
  $number_marqueur = $_POST['number_marqueur'];
  $center_map_long = $_POST['center_map_long'];
  $center_map_lat = $_POST['center_map_lat'];
  $map_zoom_level = $_POST['map_zoom_level'];

  global $chk;

  for ($i = 1; $i <= get_option('af_p5_number_marqueur'); $i++) {
    $m_long = 'af_p5_m' . $i . '_long';
    $m_lat = 'af_p5_m' . $i . '_lat';
    ${$m_long} = $_POST['af_p5_m' . $i . '_long'];
    ${$m_lat} = $_POST['af_p5_m' . $i . '_lat'];

    if (get_option('af_p5_m' . $i . '_long') != trim(${$m_long})) {
      $chk = update_option('af_p5_m' . $i . '_long', trim(${$m_long}));
    }
    if (get_option('af_p5_m' . $i . '_lat') != trim(${$m_lat})) {
      $chk = update_option('af_p5_m' . $i . '_lat', trim(${$m_lat}));
    }
  }

  if (get_option('af_p5_number_marqueur') != trim($number_marqueur)) {
    $chk = update_option('af_p5_number_marqueur', trim($number_marqueur));
  }
  if (get_option('af_p5_center_map_long') != trim($center_map_long)) {
    $chk = update_option('af_p5_center_map_long', trim($center_map_long));
  }
  if (get_option('af_p5_center_map_lat') != trim($center_map_lat)) {
    $chk = update_option('af_p5_center_map_lat', trim($center_map_lat));
  }
  if (get_option('af_p5_map_zoom_level') != trim($map_zoom_level)) {
    $chk = update_option('af_p5_map_zoom_level', trim($map_zoom_level));
  }
}

?>


<div class="wrap">
    <div id="icon-options-general" class="icon32"><br>
    </div>
    <h2>Leaflet map settings</h2>
  <?php if (isset($_POST['wphw_submit']) && $chk): ?>
      <div id="message" class="updated below-h2">
          <p>Content updated successfully</p>
      </div>
  <?php endif; ?>
    <div class="metabox-holder">
        <div class="postbox">
            <form method="post" action="">
                <h3><strong>Centre de la map.</strong></h3>
                <table class="form-table">
                    <tr>
                        <th scope="row">Latitude</th>
                        <td><input type="text" name="center_map_long" placeholder="Long"
                                   value="<?php echo get_option('af_p5_center_map_long'); ?>" style="width:200px;"/></td>
                        <td>Longitude</td>
                        <td><input type="text" name="center_map_lat" placeholder="Lat"
                                   value="<?php echo get_option('af_p5_center_map_lat'); ?>" style="width:200px;"/></td>
                      <td>Zoom Level</td>
                      <td><input type="text" name="map_zoom_level" placeholder="Zoom"
                                 value="<?php echo get_option('af_p5_map_zoom_level'); ?>" style="width:200px;"/></td>
                    </tr>
                </table>
                <h3><strong>Nombre de marqueurs</strong></h3>
                <table class="form-table">
                    <tr>
                        <th scope="row">Nombre de marqueurs</th>
                        <td><input type="text" name="number_marqueur" placeholder="Combien de marqueurs ?"
                                   value="<?php echo get_option('af_p5_number_marqueur'); ?>" style="width:350px;"/></td>
                    </tr>
                </table>
                <br/>
              <?php
              for ($i = 1; $i <= get_option('af_p5_number_marqueur'); $i++) {
                ?>
                  <h3><strong>Marqueur n°<?= $i ?> de la map.</strong></h3>
                  <table class="form-table">
                      <tr>
                          <th scope="row">Latitude</th>
                          <td><input type="text" name="<?php echo('af_p5_m' . $i . '_long') ?>" placeholder="Long"
                                     value="<?php echo get_option('af_p5_m' . $i . '_long'); ?>" style="width:350px;"/></td>
                          <td>Longitude</td>
                          <td><input type="text" name="<?php echo('af_p5_m' . $i . '_lat') ?>" placeholder="Lat"
                                     value="<?php echo get_option('af_p5_m' . $i . '_lat'); ?>" style="width:350px;"/></td>
                      </tr>
                  </table>
                <?php
              }
              ?>
                <table class="form-table">
                    <tr>
                        <th scope="row">&nbsp;</th>
                        <td style="padding-top:10px;  padding-bottom:10px;">
                            <input type="submit" name="wphw_submit" value="Save changes" class="button-primary"/>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>
