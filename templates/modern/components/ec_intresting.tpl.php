<?php 

$ec_intresting = $this->getDataValue('content', 'ec_intresting'); 

?>

<?php if(!empty($ec_intresting)) { ?>

<div class="component-wrap intresting-wrap">
    
    <h2 class="title-extra"><?php echo $this->escape($ec_intresting['title']); ?></h2>
    
    <p class="p2" style="text-align: left;"><?php echo $this->escape($ec_intresting['text']); ?></p>
    
</div>

<?php } ?>