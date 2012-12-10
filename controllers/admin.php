<?php
if ( isset( $_POST['m4h-add-user'] ) ) {
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
  $data = array (
    "fname" => $fname,
    "lname" => $lname,
    "email" => $email,
    "phone" => $phone,
    "website" => $website,
    "address1" => $address1,
    "address2" => $address2,
    "city" => $city,
    "state" => $state,
    "zip" => $zip
  );

  validate_data($data);

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
  foreach( $data as $field => $v ) {
    if ( ( empty( $v ) ) && ( $field !== 'website' && $field !== 'address2' ) ) {
      echo "$field is empty<br/>"; 
    }
  }
  if( !preg_match( '/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/', $data['phone'] ) ) {
    echo "Phone # is incorrect";
  }
  //echo "Phone #: " . preg_match( '/\d{3}-\d{3}-\d{4}/', $data['phone'] );
}

?>
