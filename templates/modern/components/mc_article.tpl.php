<?php 

$mc_article = $this->getDataValue('content', 'mc_article'); 

?>

<?php if(!empty($mc_article)) { ?>

<div class="component-wrap">
    
    <h2 class="article-title"><?php echo $this->escape($mc_article['main']['title']); ?></h2>
    
    <?php if(!empty($mc_article['images']['M'])) { ?>
    
    <div style="float: left;">
        
        <img src="<?php echo $mc_article['images']['M']['image_path']; ?>" alt="<?php echo $mc_article['images']['M']['alt']; ?>" class="img-main" />
        
    </div>
    
    <?php } ?>
    
    <p class="article-prevDescr"><?php echo $this->escape($mc_article['main']['prev_description']); ?></p>

    <br />
    
    <div class="article-text"><?php echo $this->renderArticleText($mc_article['main']['full_description']); ?></div>
    
</div>

<?php } ?>