<?php namespace cahnrswp\cahnrs\googlesearch;?>
<header id="search-header">
<div class="search-text">Your search for <strong><?php echo $this->search_model->term;?></strong> returned <strong><?php echo $this->search_model->total_results;?></strong> results.</div> 
	<div id="search-form" data-serviceurl="<?php echo get_site_url(); ?>">
    	<label>New Search: </label><input id="search-term" type="text" name="term" value="<?php echo $this->search_model->term;?>" /><a href="#" >GO</a>
    </div>
</header>
<nav id="search-nav">
	<a href="#" class="activesearch search-loaded" data-type="google-wsu" data-tooltip="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc pellentesque lectus ut sem convallis, non porta nisi pulvinar. Cras vestibulum, diam vel blandit semper, felis mi porttitor lorem, a egestas dolor sem in magna. Proin turpis sem, consequat ut porttitor et, congue id urna." >
    	WSU
    </a><a class="" href="#" data-type="google-universities" data-tooltip="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc pellentesque lectus ut sem convallis, non porta nisi pulvinar. Cras vestibulum, diam vel blandit semper, felis mi porttitor lorem, a egestas dolor sem in magna. Proin turpis sem, consequat ut porttitor et, congue id urna." >
    	Other Universities
    </a><a class="" href="#" data-type="google-related" data-tooltip="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc pellentesque lectus ut sem convallis, non porta nisi pulvinar. Cras vestibulum, diam vel blandit semper, felis mi porttitor lorem, a egestas dolor sem in magna. Proin turpis sem, consequat ut porttitor et, congue id urna." >
        Trade Articles
    </a><a class="" href="#" data-type="wtfrc" data-tooltip="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc pellentesque lectus ut sem convallis, non porta nisi pulvinar. Cras vestibulum, diam vel blandit semper, felis mi porttitor lorem, a egestas dolor sem in magna. Proin turpis sem, consequat ut porttitor et, congue id urna.">
    	WTFRC Reports
    </a><a class="" href="#" data-type="google-technical" data-tooltip="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc pellentesque lectus ut sem convallis, non porta nisi pulvinar. Cras vestibulum, diam vel blandit semper, felis mi porttitor lorem, a egestas dolor sem in magna. Proin turpis sem, consequat ut porttitor et, congue id urna.">
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