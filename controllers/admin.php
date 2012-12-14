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
    'Zip' => array( $_POST['zip'], true ),
    'Latitude' => array( $_POST['lat'], false),
    'Longitude' => array( $_POST['lng'], false)
  );

  $Errors = validate_data($data);

  if ( empty( $Errors ) ) {
    $data = sanitize_data($data);
    $address = array(
      'address1' => $data['Address 1'],
      'address2' => $data['Address 2'],
      'city'     => $data['City'],
      'state'    => $data['State'],
      'zip'      => $data['Zip']
    ); 

    if ( $data['Latitude'] === '' || $data['Longitude'] === '') {
      $coords = geocode( $address );
      $data['Latitude'] = $coords['lat'];
      $data['Longitude'] = $coords['lng'];
    }

    m4h_add_member( $data );
    /*
    $response = wp_remote_get('http://maps.google.com/maps/api/geocode/json?sensor=false&language=en&address=1320+E+Verlea+Dr,+Tempe,+AZ+85282');
    if ( !is_wp_error( $response ) ) {
      $json = json_decode( wp_remote_retrieve_body( $response ) );
      echo $json->results[0]->geometry->location->lat;
      echo $json->results[0]->geometry->location->lng;
    }
     */
  }

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
    if( preg_match( '/^\d{5}(?:[-\s]\d{4})?$/', $data['Zip'][0] ) == false) {
      array_push( $Errors, 'Zip Code is invalid.' );
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

function sanitize_data( $data ) {
  foreach( $data as $k => $v ) {
    if( is_email( $data[$k][0] ) ) {
      $data[$k] = sanitize_email( $data[$k][0] );
    }
    else {
      $data[$k] = sanitize_text_field( $data[$k][0] );
    }
  }
  return $data;
}

function geocode($address) {
  $gapi = 'http://maps.google.com/maps/api/geocode/json?sensor=false&language=en&address=';

  // sanitize address
  foreach($address as $k => $v) {
    $address[$k] = preg_replace( '/[^a-zA-Z0-9]+/', '+', trim($v) );
  } 

  // format address
  $address = urlencode( implode( ', ', $address) );

  $response = wp_remote_get( $gapi . $address );
  if ( !is_wp_error( $response ) ) {
    $json = json_decode( wp_remote_retrieve_body( $response ) );
  }
  return array( 
    'lat' => $json->results[0]->geometry->location->lat, 
    'lng' => $json->results[0]->geometry->location->lng
  );
}

function m4h_add_member($data) {
  global $wpdb;
  $sql = $wpdb->prepare( "
    INSERT INTO $wpdb->prefix" . "m4h
    ( fname, lname, email, phone, website, address1, address2, city, state, zip, lat, lng )
    VALUES ( %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %10.7f, %10.7f)",
      $data['First Name'], 
      $data['Last Name'], 
      $data['Email'], 
      $data['Phone Number'], 
      $data['Website'], 
      $data['Address 1'], 
      $data['Address 2'], 
      $data['City'], 
      $data['State'], 
      $data['Zip'], 
      $data['Latitude'], 
      $data['Longitude'] 
  );

  $wpdb->query( $sql );
}
?>
