<?php
if ( isset( $_POST['m4h-add-user'] ) ) {
  global $Errors;

  $data = array (
    'First Name' => array( $_POST['fname'], true ),
    'Last Name' => array( $_POST['lname'], true ),
    'Email' => array( $_POST['email'], true ),
    'Phone Number' => array( $_POST['phone'], true ),
    'Website' => array( $_POST['website'], false ),
    'Address 1' => array( $_POST['address1'], true ),
    'Address 2' => array( $_POST['address2'], false ),
    'City' => array( $_POST['city'], true ),
    'State' => array( $_POST['state'], true ),
    'Zip' => array( $_POST['zip'], true )
  );

  $Errors = validate_data($data);
  /*
  $addrKeys = array( 'address1', 'address2', 'city', 'state', 'zip' );

  foreach ( $addrKeys as $addrKey ) {
    $address[$addrKey] = sanitize_text_field( $_POST[$addrKey] );
  }

  $username = strtolower( substr($fname, 0, 1) . $lname );
  */


}

/*
 * Expects array containing member field data
 */
function validate_data($data) {
  $Errors = array();

  foreach( $data as $field => $v ) {
    if ( empty( $v[0] ) && $v[1] === true ) {
      array_push( $Errors, $field );
    } 
  }

  if ( empty( $Errors ) ) {
    if( preg_match( '/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/', $data['Phone Number'][0] ) == false ) {
      array_push( $Errors, 'Phone number is invalid' );
    }
    if ( !is_email( $data['Email'][0] ) ) {
      array_push( $Errors, 'Email is invalid.' );
    }
    // General validation
    foreach( $data as $field => $v ) {
      if ( strlen( $v[0] ) < 3 && $v[1] && $field !== 'State' ) {
        array_push( $Errors, "$field is too short." );
      }
    } 
  }

  return $Errors;
}

?>
