<?php namespace cahnrswp\cahnrs\googlesearch;?>
<div class="search-result">
    <div class="search-image" style="background-image: url(<?php echo $result['img'];?>);">
    </div>
    <div class="search-text<?php if( isset( $result['pagemap']['cse_thumbnail'] ) ) echo ' has-image';?>">
        <h2>
            <a href="<?php echo $result['link'];?>" target="_blank" ><?php echo $result['title'];?></a>
        </h2>
        <div class="search-url"><?php echo $result['link'];?></div>
        <div class="search-desc"><?php echo $result['snippet'];?></div>
    </div>
</div>