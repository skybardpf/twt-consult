<?php
$conf = array (
  'apps' => 
  array (
    'cms' => 'cms',
    'site' => 'site',
  ),
  'host_mapping' => NULL,
  'uri_mapping' => 
  array (
    'cms' => 
    array (
      'uri' => 
      array (
        0 => '/cms/',
        1 => '/admin/',
      ),
      'bind2hosts' => 'any',
    ),
  ),
  'default_app' => 'site',
);
?>