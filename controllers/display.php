<?php
if ( isset( $_POST['m4h-search'] ) ) {
  global $SearchErrors;

  $query = array(
    'type' => array( $_POST['search-type'], true) ,
    'query' => array( $_POST['search-query'], true),
    'radius' => array( $_POST['search-radius'], false )
  );

  // set default radius
  if( (int)$query['radius'] < 1 )
    $query['radius'] = 5;

  if( (int)$query['radius'] === '' && $query['type'] == 'address' )
    $query['radius'] = 5;

  $SearchErrors = validate_query( $query );

  if( empty( $SearchErrors ) ) {
    $query =  sanitize_query( $query );
  }

}

function validate_query($data) {
  $SearchErrors = array();
  $zipReg = '/^\d{5}(?:[-\s]\d{4})?$/';

  // check for nulls
  foreach( $data as $k => $v ) {
    if ( $v[0] !== '' && $v[1] === true )
      array_push( $SearchErrors, $k);
  }

  if( empty( $SearchErrors ) ) {
    if ( preg_match( $zipReg, $data['query'][0] ) == false 
      && $data['type'][0] == 'zip' )
      array_push( $SearchErrors, 'Please use a valid Zip Code.' );

    if ( $data['query'][0] == 'state' && strlen( $data['query'][0] ) > 2 )
      array_push( $SearchErrors, 'Please abbreviate the State.');
  }

  return $SearchErrors;
}

function sanitize_query( $data ) {
  foreach( $data as $k => $v ) {
    $data[$k] = sanitize_text_field( $data[$k][0] );
  }

  return $data;
}

?>
