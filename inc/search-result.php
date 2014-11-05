<?php namespace cahnrswp\cahnrs\googlesearch;?>
<div class="search-result">
	<?php if( isset( $result['pagemap']['cse_thumbnail'] ) ):?>
    <div class="search-image" style="background-image: url(<?php echo $result['pagemap']['cse_thumbnail'][0]['src'];?>);">
    </div>
    <?php endif;?>
    <div class="search-text<?php if( isset( $result['pagemap']['cse_thumbnail'] ) ) echo ' has-image';?>">
        <h2>
            <a href="<?php echo $result['link'];?>" ><?php echo $result['title'];?></a>
        </h2>
        <div class="search-url"><?php echo $result['link'];?></div>
        <div class="search-desc"><?php echo $result['snippet'];?></div>
    </div>
</div>