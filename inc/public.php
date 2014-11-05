<?php namespace cahnrswp\cahnrs\googlesearch;?>
<header id="search-header">
Your search for <strong><?php echo $this->search_model->term;?></strong> returned <strong><?php echo $this->search_model->total_results;?></strong>. 
	<div id="search-form" data-serviceurl="<?php echo get_site_url(); ?>">
    	<input id="search-term" type="text" name="term" value="<?php echo $this->search_model->term;?>" />
    </div>
</header>
<nav id="search-nav">
	<a href="#" class="activesearch search-loaded" data-type="wsu" >Search WSU</a><a href="#" data-type="related" >Search Related Websites</a><a href="#" data-type="wtfrc">Search WTFRC Reports</a>
</nav>
<div id="search-wsu" class="search-section">
	<?php foreach( $this->search_model->results as $result ){
    	include 'search-result.php';
	};?>
</div>
<div id="search-related" class="search-section">
</div>
<div id="search-wtfrc" class="search-section">
</div>