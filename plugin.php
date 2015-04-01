<?php namespace cahnrswp\cahnrs\googlesearch;
/**
* Plugin Name: Google Site Search
* Plugin URI:  http://cahnrs.wsu.edu/communications/
* Description: Adds Google base site search
* Version:     0.1
* Author:      CAHNRS Communications, Danial Bleile
* Author URI:  http://cahnrs.wsu.edu/communications/
* License:     Copyright Washington State University
* License URI: http://copyright.wsu.edu
*/
class init_google_search{
	
	public $search_model;
	public $search_controller;
	public $search_view;
	
	public function __construct(){
		
		define( __NAMESPACE__.'\URL' , plugin_dir_url( __FILE__ ) ); // PLUGIN BASE URL
		define( __NAMESPACE__.'\DIR' , plugin_dir_path( __FILE__ ) ); // DIRECTORY PATH
		
		\register_activation_hook( __FILE__, array( $this , 'activate_plugin' ) );
		
		\add_shortcode( 'GOOGLESEARCH', array( $this , 'add_search_public' ) );
		
		if( !is_admin() ){
			\add_action( 'wp_enqueue_scripts', array( $this , 'add_scripts' ) );
		}
		
		if( isset( $_GET['is-search-service'] ) ){
			\add_filter( 'template_include', array( $this , 'search_service' ) , 99 );
		}
	}
	
	public function activate_plugin(){
		if( !get_page_by_path( 'site-search' ) ) {
			$args = array(
				'post_title' => 'Site Search',
				'post_content' => '[GOOGLESEARCH]',
				'post_name' => 'site-search',
				'post_type' => 'page',
				'post_status' => 'publish',
				);
			\wp_insert_post( $args ); 
		}
	}
	
	public function add_search_public( $args = array() ){
		$this->search_model = new search_model( $args );
		$this->search_controller = new search_controller( $this->search_model );
		$this->search_controller->do_search();
		$this->search_view = new search_view( $this->search_controller , $this->search_model );
		ob_start();
		$this->search_view->output_public();
		return ob_get_clean();
	}
	
	
	
	public function add_scripts(){
		if ( is_page( 'site-search' ) ) {
			 \wp_enqueue_style( 'search-css', URL.'/css/search.css', array(), '0.0.2'  );
			 \wp_enqueue_script( 'search-js', URL.'/js/search.js', array(), '0.0.2'  );
  		}
	}
	
	public function search_service( $template ){
		return DIR.'inc/service.php';
	}
	
};

class search_model{
	private $api_key = 'AIzaSyB7d9IJ6IVhch-VZ-cIPak08Lvq5XqWd34';
	public $type = 'google-wsu';
	public $view_type = 'public';
	public $count = 10;
	public $term = '';
	public $start = 0;
	public $sites = array(
		'google-wsu' => '004797236515831676218:cgtd4l4bzpi',
		'google-related' => '004797236515831676218:ryuu0i9rqi8',
		'google-technical' => '004797236515831676218:rjprotvk0ra',
		'google-universities' => '004797236515831676218:0s5ex8riqsk',
		);
	public $site = '004797236515831676218:cgtd4l4bzpi';
	public $siteSearch  = false;
	public $sort = false;
	public $content_type = false;
	public $searchsite = false;
	public $query;
	public $results = false;
	public $total_results = 0;
	
	public function __construct( $args = array() ){
		if( isset( $args['type'] ) ) $this->type = $args['type'];
		if( array_key_exists( $this->type , $this->sites ) ) $this->site = $this->sites[ $this->type ];
		if( isset( $args['count'] ) ) $this->count = $args['count'];
		if( isset( $args['view_type'] ) ) $this->view_type = $args['view_type'];
		if( isset( $args['sort'] ) ) $this->sort = $args['sort'];
		if( isset( $args['filetype'] ) ) $this->content_type = $args['filetype'];
		if( isset( $args['searchsite'] ) ) $this->searchsite = $args['searchsite']; 
		if( isset( $args['start'] ) ) $this->start = $args['start'];
		if( isset( $args['term'] ) ) { 
			$this->term =  $args['term']; 
		}
		else if (  $_GET['term'] ) {
			$this->term = $_GET['term'] ;
		}
	}
	
	public function set_term( $term = ''){
		$this->term = $term;
	}
	
	public function set_type( $type = 'google-wsu'){
		$this->type = $type;
	}
	
	public function set_query(){
		switch ( $this->type ){
			case 'google-technical':
			case 'google-related':
			case 'google-universities': 
			case 'google-wsu':
				$query = 'https://www.googleapis.com/customsearch/v1?';
				$query .= 'q='.urlencode( $this->term );
				$query .= '&cx='.$this->site;
				$query .= '&key='.$this->api_key;
				$query .= '&num='.$this->count;
				if( $this->sort ) $query .= '&sort='.$this->sort;
				if( $this->content_type ) $query .= '&fileType='.$this->content_type;
				if( $this->searchsite ) $query .= '&siteSearch='.$this->searchsite;
				if( $this->start ) $query .= '&start='.$this->start; 
				$this->query = $query;
				break;
			case 'wtfrc': 
				$query = 'http://jenny.tfrec.wsu.edu/onestop/qWTFRConTitles.php?';
				$query .= 'shorten=1';
				$query .= '&terms='.urlencode( $this->term );
				$query .= '&firstrec=1';
				$query .= '&nreturn='.$this->count;
				$this->query = $query;
				break;
		}
	}
	
	public function set_results(){
		switch ( $this->type ){
			case 'google-technical':
			case 'google-related':
			case 'google-universities':
			case 'google-wsu':
				$res = @file_get_contents( $this->query );
				//$res = @file_get_contents( DIR.'/testing/json.php' );
				if( $res ){
					$res = json_decode( $res , true );
					if( $res ){
						$this->results = $res['items'];
						foreach( $this->results as &$result ){
							if( isset( $result['pagemap']['cse_thumbnail'] ) ){
								$result['img'] = $result['pagemap']['cse_thumbnail'][0]['src'];
							} else {
								$result['img'] = URL.'/images/blank-image.png';
							}
						}
						$this->total_results = $res[ 'queries' ]['request'][0]['totalResults'];
						//var_dump( $res[ 'queries' ]['request'] );
					} else {
						$this->results = false;
					}
				} else {
					$this->results = false;
				}
				break;
			case 'wtfrc': 
				//$res = @file_get_contents( $this->query );
				
				$res = wp_remote_get( $this->query  );
				
				$res = wp_remote_retrieve_body( $res );
				
				$res = mb_convert_encoding ( $res , "UTF-8" );
				
				if( $res ){
					$res = json_decode( $res , true );
					if( $res ){
						$this->results = $res['qtfrec']['results'];
						foreach( $this->results as $res_key => &$res_value ){
							$res_value = reset( $res_value );
							$res_value['title'] = strip_tags( html_entity_decode( $res_value['title'] ) );
							$res_value['link'] = strip_tags( html_entity_decode( $res_value['url'] ) );
							$res_value['snippet'] = strip_tags( html_entity_decode( $res_value['sectxt'] ) );
							$res_value['img'] = URL.'images/WTFRC_Logo.jpg';
						}
						
						$this->total_results = $res[ 'numRecords'];
					} else {
						$this->results = false;
					} 
				} else {
					$this->results = false;
				}
				break;
		}
	}
}

class search_controller{
	
	public $search_model;
	
	public function __construct( $model ){
		$this->search_model = $model;
	}
	
	public function do_search(){
		$this->search_model->set_query();
		$this->search_model->set_results();
	}
}

class search_view {
	private $search_controller;
	private $search_model;
	
	public function __construct( $controller , $model ){
		$this->controller = $controller;
		$this->search_model = $model;
	}
	
	public function output_public(){
		switch ( $this->search_model->view_type ){
			case 'public':
				include 'inc/public.php';
				break;
			case 'service':
				if( $this->search_model->results ){
					
					echo '<div class="search-totals"><strong>' . $this->search_model->total_results .'</strong> results returned.</div>';
					foreach( $this->search_model->results as $result ){
						include 'inc/search-result.php';
					}; // end foreach
				} // end if
				break;
		}
		
	}
}



$google_search = new init_google_search();
