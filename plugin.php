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
		
		if( isset( $_GET['search-service'] ) ){
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
	
	public function add_search_public( $atts = array( 'type' => 'wsu' , 'service' => false ) ){
		$this->search_model = new search_model();
		$this->search_controller = new search_controller( $this->search_model );
		$this->search_controller->search( $atts['type'] );
		$this->search_view = new search_view( $this->search_controller , $this->search_model );
		
		ob_start();
		if( !$atts['service'] ){
			$this->search_view->output_public();
		} else {
			$this->search_view->output_service();
		}
		return ob_get_clean();
	}
	
	
	
	public function add_scripts(){
		if ( is_page( 'site-search' ) ) {
			 \wp_enqueue_style( 'search-css', URL.'/css/search.css', array(), '0.0.1'  );
			 \wp_enqueue_script( 'search-js', URL.'/js/search.js', array(), '0.0.1'  );
  		}
	}
	
	public function search_service( $template ){
		return DIR.'inc/service.php';
	}
	
};

class search_model{
	private $api_key = 'AIzaSyB7d9IJ6IVhch-VZ-cIPak08Lvq5XqWd34';
	public $n;
	public $term;
	public $site = '004797236515831676218%3Ajjbaaricka8';
	public $query;
	public $results = array();
	public $total_results = 0;
	
	public function set_query_params(){
		$this->n = '10';
		$this->term =  ( isset( $_GET['term'] ) )? $_GET['term'] : '';
		$this->term = urlencode( $this->term );
	}
	
	public function set_google_query(){
		$this->query = 'https://www.googleapis.com/customsearch/v1?q='.
			$this->term.
			'&cx='.$this->site.
			'&key='.$this->api_key.'&num=10';
	}
	
	public function set_wtfrc_query(){
		$this->query = 'http://jenny.tfrec.wsu.edu/onestop/qWTFRC.php?shorten=1&terms='.$this->term.'&firstrec=1&nreturn=10';
	}
	
	public function set_wtfrc_results(){
		$res = @file_get_contents( $this->query );
		if( $res ){
			$res = json_decode( $res , true );
			if( $res ){
				$this->results = $res['qtfrec']['results'];
				foreach( $this->results as $res_key => &$res_value ){
					$res_value = reset( $res_value );
					$res_value['title'] = strip_tags( html_entity_decode( $res_value['title'] ) );
					$res_value['link'] = strip_tags( html_entity_decode( $res_value['url'] ) );
					$res_value['snippet'] = strip_tags( html_entity_decode( $res_value['sectxt'] ) );
				}
				
				$this->total_results = $res[ 'numRecords'];
			}
		}
	}
	
	public function set_google_results(){
		$res = @file_get_contents( $this->query );
		//$res = @file_get_contents( DIR.'testing/json.php' );
		if( $res ){
			$res = json_decode( $res , true );
			if( $res ){
				$this->results = $res['items'];
				$this->total_results = $res[ 'queries' ]['request']['totalResults'];
			}
		}
	}
}

class search_controller{
	
	public $search_model;
	
	public function __construct( $model ){
		$this->search_model = $model;
	}
	
	public function search( $type = 'wsu' ){
		
		$this->search_model->set_query_params();
		switch( $type ){
			case 'wtfrc':
				$this->search_model->set_wtfrc_query();
				$this->search_model->set_wtfrc_results();
				break;
			default:
				$this->search_model->set_google_query();
				$this->search_model->set_google_results();
				break;
		}
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
		include 'inc/public.php';
	}
	
	public function output_service(){
		foreach( $this->search_model->results as $result ){
    		include 'inc/search-result.php';
		};
	}
}



$google_search = new init_google_search();
