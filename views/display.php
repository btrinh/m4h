<?php
/*
add_action( 'wp_enqueue_scripts', function() {
  wp_register_style( 'm4h-bootstrap-mod', plugins_url( '/m4h/css/bootstrap-mod.min.css' ) );
  wp_enqueue_style( 'm4h-bootstrap-mod' );
});
//*/

function m4h_members_search() {
?>
<form id="m4h-members-search" class="" method="post" action="">
  <legend>Find A Realtor In Your Community Who Gives Back</legend>
  <div class="control">
    <select class="span2" name="search-type">
      <option selected>Search by...</option>
      <option value="address">Address</option>
      <option value="city">City</option>
      <option value="state">State (abbreviated)</option>
      <option value="zip">Zip Code</option>
    </select>
  </div>

  <div class="control-group">

    <input class="span4" name="search-query" type="text">
    <input class="input-small" name="search-radius" type="text" placeholder="Radius (miles)">
  </div>
  
  <div class="form-actions">
    <button class="btn btn-success" name="m4h-search" type="submit">Search</button>
  </div>

</form>
<?php
}
?>
