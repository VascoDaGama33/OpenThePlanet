<?php 

$mc_articles_list = $this->getDataValue('content', 'mc_articles_list'); 

?>

<?php if (!empty($mc_articles_list) && is_array($mc_articles_list)) { ?>

<div>
    
    <?php foreach ($mc_articles_list as $k => $v) { ?>
    
        <div>
        
            <h2 class="list-articleTitle">

			<a href="<?php echo $this->getUrl(array('country' => $v['country_id'], 'section' => 2, 'id' => $v['id'])); ?>">

				<?php echo $this->escape($v['title']); ?></h2>

	              </a>
	    </h2>
        
            <div class="wrap">
                
                <img src="<?php echo $v['images']['AV']['image_path']; ?>" alt="<?php echo $v['images']['AV']['alt']; ?>" class="img-avatar" >
                
                <div class="extra-wrap">
                    
                    <p class="article-prevDescr"><?php echo $this->escape($v['prev_description']); ?></p>
                    
                </div>

            </div>
        
            <p class="p5"><?php echo $this->escape($v['short_description']); ?></p>
        
            <a href="<?php echo $this->getUrl(array('country' => $v['country_id'], 'section' => 2, 'id' => $v['id'])); ?>" class="button">Читать дальше</a>
        
        </div>
    
    <?php } ?>
    
</div>

<?php } ?>