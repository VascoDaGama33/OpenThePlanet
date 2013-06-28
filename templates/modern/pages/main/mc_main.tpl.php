<?php

$mc_main = $this->getDataValue('content', 'mc_main');

?>

<?php if(!empty($mc_main)) { ?>

    <?php foreach($mc_main as $k => $v) { ?>

    <div>
    
        <h2 class="list-mainTitle"><?php echo $this->escape($v['title']); ?></h2>
     
        <img src="<?php echo $v['images']['M']['image_path']; ?>" alt="<?php echo $v['images']['M']['alt']; ?>" class="img-main" />
  
        <div class="p2"><?php echo $this->renderArticleText($v['text']); ?></div>

    </div>

    <?php } ?>

<?php } ?>