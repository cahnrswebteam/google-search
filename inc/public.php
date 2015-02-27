<?php namespace cahnrswp\cahnrs\googlesearch;?>
<header id="search-header">
<div class="search-text">Your search for <strong><?php echo $this->search_model->term;?></strong> returned <strong><?php echo $this->search_model->total_results;?></strong> results.</div> 
	<div id="search-form" data-serviceurl="<?php echo get_site_url(); ?>">
    	<label>New Search: </label><input id="search-term" type="text" name="term" value="<?php echo $this->search_model->term;?>" /><a href="#" >GO</a>
    </div>
</header>
<nav id="search-nav">
	<a href="#" class="activesearch search-loaded" data-type="google-wsu" data-tooltip="This tab searches the entire WSU domain.  These are considered the most relevant resources for Washington-based information.." >
    	WSU
    </a><a class="" href="#" data-type="google-universities" data-tooltip="This tab searches tree fruit resources from other Land-Grant universities across the U.S. including but not limited to: University of California, Oregon State University, Cornell University, Michigan State University, Pennsylvania State University, and Clemson University." >
    	Other Universities
    </a><a class="" href="#" data-type="google-related" data-tooltip="This tab searches the databases for the Good Fruit Grower, American/Western Fruit Grower and Fruit Grower News magazines." >
        Trade Articles
    </a><a class="" href="#" data-type="wtfrc" data-tooltip="This tab searches final research reports contained in the Washington Tree Fruit Research Commission database.">
    	WTFRC Reports
    </a><a class="" href="#" data-type="google-technical" data-tooltip="This tab searches technical and scientific journals.  Some articles may be available in their entirety while others may only provide an abstract and require a fee to download the entire article.  Journals include but are not limited to: HortScience, HortTechnology, Journal of the American Pomological Society, and Acta Horticulturae.">
    	Technical Articles</a>
</nav>
<div id="google-wsu" class="search-section">
	<?php include 'toolbar-google.php';?>
    <div class="cs-results-content"> 
    <?php if( is_array( $this->search_model->results ) ):?>
        <div class="search-totals"><strong><?php echo $this->search_model->total_results;?></strong> results returned.</div>
        <?php foreach( $this->search_model->results as $result ){
            include 'search-result.php';
	};?>
    <?php endif;?>
    </div>
    <a href="#" class="cs-more-results">Show More Results</a>
</div>
<div id="google-universities" class="search-section" style="display: none">
    <div class="cs-results-content loading-search">
    </div>
    <a href="#" class="cs-more-results">Show More Results</a>
</div>
<div id="google-related" class="search-section" style="display: none">
    <div class="cs-results-content loading-search">
    </div>
    <a href="#" class="cs-more-results">Show More Results</a>
</div>
<div id="wtfrc" class="search-section" style="display: none">
    <div class="cs-results-content loading-search">
    </div>
    <a href="#" class="cs-more-results">Show More Results</a>
</div>
<div id="google-technical" class="search-section" style="display: none" >
    <div class="cs-results-content loading-search">
    </div>
    <a href="#" class="cs-more-results">Show More Results</a>
</div>