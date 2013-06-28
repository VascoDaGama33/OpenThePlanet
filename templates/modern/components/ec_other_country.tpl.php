<?php

$ec_other_country = $this->getDataValue('content', 'ec_other_country');

?>

<?php if(!empty($ec_other_country)) { ?>

<div class="component-wrap">
    
    <h2 class="title-extra">Другие страны</h2>
    
    <img src="/images/_main/world_map.png" alt="">
    
    <div>
    
    <ul class="list-column-2">
        
    <?php foreach($ec_other_country as $k => $v) { ?>
  
          <li><a href="<?php echo $this->getUrl(array('country' => $v['id'], 'section' => 1)); ?>"><?php echo $this->escape($v['countryName']) ?></a></li>
    
    <?php } ?>
            
    </ul>

    </div>

</div>

<?php } ?>

 