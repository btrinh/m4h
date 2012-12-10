<?php
if ( isset( $_POST['m4h-add-user'] ) ) {

/*
  $fname = sanitize_text_field( $_POST['fname'] ); 
  $lname = sanitize_text_field( $_POST['lname'] ); 
  $email = sanitize_email( $_POST['email'] );
  $phone = sanitize_text_field( $_POST['phone'] );
  $website= sanitize_text_field( $_POST['website'] );
  $address1 = sanitize_text_field( $_POST['address1'] );
  $address2 = sanitize_text_field( $_POST['address2'] );
  $city = sanitize_text_field( $_POST['city'] );
  $state = sanitize_text_field( $_POST['state'] );
  $zip = sanitize_text_field( $_POST['zip'] );
*/
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

  $errors = validate_data($data);

    /*
  $addrKeys = array( 'address1', 'address2', 'city', 'state', 'zip' );

  foreach ( $addrKeys as $addrKey ) {
    $address[$addrKey] = sanitize_text_field( $_POST[$addrKey] );
  }

  $username = strtolower( substr($fname, 0, 1) . $lname );
   */


}

/*
 * Expects array (
 *  "fname" => $fname,
 *  "lname" => $lname,
 *  "email" => $email,
 *  "phone" => $phone,
 *  "website" => $website,
 *  "address1" => $address1,
 *  "address2" => $address2,
 *  "city" => $city,
 *  "state" => $state,
 *  "zip" => $zip
 *  );
 */
function validate_data($data) {
  $Errors = array(
    'empty' => array(),
    'validation' => array()
  );

  foreach( $data as $field => $v ) {
    if ( empty( $v[0] ) && $v[1] === true ) {
      echo "$field is empty<br/>"; 
      array_push($Errors['empty'], $field);
    } 
  }

  if ( empty( $Errors['empty'] ) ) {
    if( !preg_match( '/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/', $data['Phone Number'][0] ) )
      array_push( $Errors['validation'], 'Phone number is invalid.' ); 
    if ( !is_email( $data['Email'][0] ) )
      array_push( $Errors['validation'], 'Email is invalid.' );
    // General validation
    foreach( $data as $field => $v ) {
      if ( strlen( $v[0] ) < 3 && $v[1] && $field !== 'State' )
        array_push( $Errors['validation'], "$field is too short." );
    } 
  }



  /*
  foreach ( $Errors['validation'] as $error ) {
    //echo "$error</br>"; 
    add_action('admin_notice', function() {
      echo "<div 
    });
  }
  */
  return $Errors;
}

?>
