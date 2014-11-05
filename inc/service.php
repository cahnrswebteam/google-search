<?php namespace cahnrswp\cahnrs\googlesearch;
global $google_search;
$type = ( isset( $_GET['search-service'] ) )? $_GET['search-service'] : 'wsu'; 
echo $google_search->add_search_public( array( 'type' => $type, 'service' => true ) );