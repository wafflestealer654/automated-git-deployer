<?php
/*
 * Both functions received from Timo Huovinen's answer at http://stackoverflow.com/a/8891890/2149764
 */
function url_origin( $s, $use_forwarded_host = false )
{
  $ssl      = !empty($s['HTTPS']) && $s['HTTPS'] == 'on';
  $sp       = strtolower($s['SERVER_PROTOCOL']);
  $protocol = substr($sp, 0, strpos($sp, '/'));
  if ($ssl) {
    $protocol .= 's';
  }
  $port     = $s['SERVER_PORT'];
  if ( ( !$ssl && $port=='80' ) || ( $ssl && $port == '443' ) ) {
    $port = '';
  } else {
    $port = ':' . $port;
  }
  $host     = ( $use_forwarded_host && isset($s['HTTP_X_FORWARDED_HOST']) ) ? $s['HTTP_X_FORWARDED_HOST'] : ( isset($s['HTTP_HOST']) ? $s['HTTP_HOST'] : null );
  $host     = isset($host) ? $host : $s['SERVER_NAME'] . $port;
  return $protocol . '://' . $host;
}

function full_url( $s, $use_forwarded_host = false )
{
  return url_origin($s, $use_forwarded_host) . $s['REQUEST_URI'];
}
