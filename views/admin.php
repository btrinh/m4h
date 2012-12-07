<!-- This file is used to markup the administration form of the plugin. -->
<?php
if( !isset($_GET['page']) or $_GET['page'] !== 'm4h-admin') return;
$states = array('Alabama'=>'AL','Alaska'=>'AK','Arizona'=>'AZ','Arkansas'=>'AR','California'=>'CA','Colorado'=>'CO','Connecticut'=>'CT','Delaware'=>'DE','Florida'=>'FL','Georgia'=>'GA','Hawaii'=>'HI','Idaho'=>'ID','Illinois'=>'IL','Indiana'=>'IN','Iowa'=>'IA','Kansas'=>'KS','Kentucky'=>'KY','Louisiana'=>'LA','Maine'=>'ME','Maryland'=>'MD','Massachusetts'=>'MA','Michigan'=>'MI','Minnesota'=>'MN','Mississippi'=>'MS','Missouri'=>'MO','Montana'=>'MT','Nebraska'=>'NE','Nevada'=>'NV','New Hampshire'=>'NH','New Jersey'=>'NJ','New Mexico'=>'NM','New York'=>'NY','North Carolina'=>'NC','North Dakota'=>'ND','Ohio'=>'OH','Oklahoma'=>'OK','Oregon'=>'OR','Pennsylvania'=>'PA','Rhode Island'=>'RI','South Carolina'=>'SC','South Dakota'=>'SD','Tennessee'=>'TN','Texas'=>'TX','Utah'=>'UT','Vermont'=>'VT','Virginia'=>'VA','Washington'=>'WA','West Virginia'=>'WV','Wisconsin'=>'WI','Wyoming'=>'WY','Alberta '=>'AB','British Columbia '=>'BC','Manitoba '=>'MB','New Brunswick '=>'NB','Newfoundland and Labrador '=>'NL','Northwest Territories '=>'NT','Nova Scotia '=>'NS','Nunavut '=>'NU','Ontario '=>'ON','Prince Edward Island '=>'PE','Quebec '=>'QC','Saskatchewan '=>'SK','Yukon '=>'YT');
function m4h_view_add_user() {
?>
<div class="wrap">
  <div class="page-header">
    <h1>Move For Hunger <small>Directory Management</small></h1>
  </div>
  <form id="m4h-add-user" class="form-horizontal" method="post" action="">
    <div class="control-group">
      <label class="control-label" for="inputIcon">Email address</label>
      <div class="controls">
        <input id="email" class="span2" placeholder="Email" type="text">
    </div>
  </form>
</div><!-- /.wrapper -->
<?php
}
?>
