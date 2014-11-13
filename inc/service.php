<?php namespace cahnrswp\cahnrs\googlesearch;
global $google_search;
$type = ( isset( $_GET['search-type'] ) )? $_GET['search-type'] : 'google-wsu';
$term = ( isset( $_GET['term'] ) )? $_GET['term'] : ''; 
echo $google_search->add_search_public( array( 'type' => $type, 'view_type' => 'service' , 'term' => $term ) );