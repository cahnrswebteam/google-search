<?php namespace cahnrswp\cahnrs\googlesearch;
global $google_search;
$args = array( 'view_type' => 'service' );
if( isset( $_GET['search-type'] ) ) $args['type'] = $_GET['search-type'];
if( isset( $_GET['term'] ) ) $args['term'] = $_GET['term'];
if( isset( $_GET['sort'] ) ) $args['sort'] = $_GET['sort'];
if( isset( $_GET['filetype'] ) ) $args['filetype'] = $_GET['filetype'];
if( isset( $_GET['searchsite'] ) ) $args['searchsite'] = $_GET['searchsite'];
echo $google_search->add_search_public( $args );