<?php

$mc_gallery = $this->getDataValue('content', 'mc_gallery');

?>

<?php if(!empty($mc_gallery) && is_array($mc_gallery)) { ?>

<div class="component-wrap galleryWrap">
    
    <h3>Галлерея</h3>

    <div>
        
        <ul class="galleryList">
            
            <?php foreach($mc_gallery as $k => $v) { ?>
            
            <li><a class="fancybox" href="<?php echo $v['image_path']; ?>" data-fancybox-group="gallery" <?php if(!empty($v['title'])) { echo 'title="' . $this->escape($v['title']) . '"'; } ?>><img src="<?php echo $v['avatar_path']; ?>" alt="<?php echo $v['alt']; ?>" class="img-gallery" /></a></li>
            
            <?php } ?>
            
        </ul>
        
    </div>
    
</div>

<?php } ?>