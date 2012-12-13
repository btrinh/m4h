<!-- This file is used to markup the administration form of the plugin. -->
<?php
if( !isset($_GET['page']) or $_GET['page'] !== 'm4h-admin') {
  return;
}
else {
  add_action( 'admin_enqueue_scripts', function() {
    wp_enqueue_style( PLUGIN_NAME . '-bootstrap-mod', plugins_url( PLUGIN_NAME . '/css/bootstrap-mod.min.css' ) ); 
  });
  // echo plugins_url() . '/' . PLUGIN_NAME . '/controllers/admin.php';
}

function m4h_view_add_user() {
$states = array(
  'Alabama' => 'AL',
  'Alaska' => 'AK',
  'Arizona' => 'AZ',
  'Arkansas' => 'AR',
  'California' => 'CA',
  'Colorado' => 'CO',
  'Connecticut' => 'CT',
  'Delaware' => 'DE',
  'Florida' => 'FL',
  'Georgia' => 'GA',
  'Hawaii' => 'HI',
  'Idaho' => 'ID',
  'Illinois' => 'IL',
  'Indiana' => 'IN',
  'Iowa' => 'IA',
  'Kansas' => 'KS',
  'Kentucky' => 'KY',
  'Louisiana' => 'LA',
  'Maine' => 'ME',
  'Maryland' => 'MD',
  'Massachusetts' => 'MA',
  'Michigan' => 'MI',
  'Minnesota' => 'MN',
  'Mississippi' => 'MS',
  'Missouri' => 'MO',
  'Montana' => 'MT',
  'Nebraska' => 'NE',
  'Nevada' => 'NV',
  'New Hampshire' => 'NH',
  'New Jersey' => 'NJ',
  'New Mexico' => 'NM',
  'New York' => 'NY',
  'North Carolina' => 'NC',
  'North Dakota' => 'ND',
  'Ohio' => 'OH',
  'Oklahoma' => 'OK',
  'Oregon' => 'OR',
  'Pennsylvania' => 'PA',
  'Rhode Island' => 'RI',
  'South Carolina' => 'SC',
  'South Dakota' => 'SD',
  'Tennessee' => 'TN',
  'Texas' => 'TX',
  'Utah' => 'UT',
  'Vermont' => 'VT',
  'Virginia' => 'VA',
  'Washington' => 'WA',
  'West Virginia' => 'WV',
  'Wisconsin' => 'WI',
  'Wyoming' => 'WY',
  'Alberta' => 'AB',
  'British Columbia' => 'BC',
  'Manitoba' => 'MB',
  'New Brunswick' => 'NB',
  'Newfoundland and Labrador' => 'NL',
  'Northwest Territories' => 'NT',    
  'Nova Scotia' => 'NS',
  'Nunavut'=> 'NU',
  'Ontario'=> 'ON',
  'Prince Edward Island' => 'PE',
  'Quebec '=> 'QC',
  'Saskatchewan'=> 'SK',
  'Yukon'=> 'YT'
);
global $Errors;
?>
<div class="wrap">
  <!--
  <div class="page-header">
    <h1>Move For Hunger <small>Directory Management</small></h1>
  </div>
  -->
  <legend>Add A User</legend>
  <?php
  if ( !empty( $Errors ) ) {
  ?>
  <div class="alert alert-error alert-block">
  <h4>Errors:</h4>
  <?php
    foreach( $Errors as $error ) {
      echo "<p>$error</p>";
    }
    echo '</div>';
  }
  ?>
  <form id="m4h-add-user" class="form-horizontal" method="post" action="">
    <?php
    $fields = array(
      'First Name' => array('fname', true, ''),
      'Last Name' => array('lname', true, ''),
      'Email' => array('email', true, ''),
      'Phone Number' => array('phone', true, 'e.g. 111-222-3333'),
      'Website' => array('website', false, ''),
      'Address 1' => array('address1', true, ''),
      'Address 2' => array('address2', false, ''),
      'City' => array('city', true, '')
    );
    foreach( $fields as $k => $v) {
    ?>
    <div class="control-group">
      <label class="control-label" for="<?php echo $v[0]; ?>"><?php echo $k; ?></label>
      <div class="controls">
      <input type="text" class="span3" placeholder="<?php echo $k ?>" name="<?php echo $v[0] ?>">
      <?php
      if ( !empty( $v[2] ) && $v[2] !== 0 )
        echo "<span class=\"help-inline\">$v[2]</span>";
      ?>
      </div>
    </div>
    <?php
    }
    ?>
    <div class="control-group">
      <label class="control-label" for="state">State</label>
      <div class="controls">
        <select id="state" name="state">    
        <?php
        foreach( $states as $state => $state_abbr ) {
        ?>
          <option value="<?php echo $state_abbr; ?>"><?php echo $state; ?></option>
        <?php
        }
        ?>
        </select>
      </div>
    </div>

    <div class="control-group">
      <label class="control-label" for="zip">Zip</label>
      <div class="controls">
        <input name="zip" class="span3" placeholder="Zip" type="text">
      </div>
    </div>
    <div class="form-actions">
      <button type="submit" id="m4h-add-user" name="m4h-add-user" class="btn btn-primary">Add User</button>
    </div>

  </form>
</div><!-- /.wrapper -->
<?php
}
?>
