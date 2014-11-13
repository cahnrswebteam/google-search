<?php namespace cahnrswp\cahnrs\googlesearch;?>
<header id="search-header">
Your search for <strong><?php echo $this->search_model->term;?></strong> returned <strong><?php echo $this->search_model->total_results;?></strong>. 
	<div id="search-form" data-serviceurl="<?php echo get_site_url(); ?>">
    	<input id="search-term" type="text" name="term" value="<?php echo $this->search_model->term;?>" />
    </div>
</header>
<nav id="search-nav">
	<a href="#" class="activesearch search-loaded" data-type="google-wsu" >Search WSU</a><a class="" href="#" data-type="google-related" >Search Related Websites</a><a class="" href="#" data-type="wtfrc">Search WTFRC Reports</a>
</nav>
<div id="google-wsu" class="search-section">
	<?php foreach( $this->search_model->results as $result ){
    	include 'search-result.php';
	};?>
</div>
<div id="google-related" class="search-section loading-search">
</div>
<div id="wtfrc" class="search-section loading-search">
</div>