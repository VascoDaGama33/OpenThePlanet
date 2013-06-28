<?php 
$disp = Dispatcher::getInstance();
$options = $disp->getOptions();

$mc_cities_list = $this->getDataValue('content', 'mc_cities_list'); 
?>

<?php if(!empty($mc_cities_list) && is_array($mc_cities_list)) { ?>

<div class="component-wrap">
    
    <?php foreach($mc_cities_list as $k => $v) { ?>
    
    <div class="cityListWrap">
        
        <div>
            
            <a href="<?php echo $this->getUrl(array('country' => $options['country'], 'section' => $options['section'], 'id' => $v['id'])); ?>">
                
                <img src="<?php echo $v['images']['AV']['image_path']; ?>" alt="<?php echo $this->escape($v['images']['AV']['alt']); ?>" class="cityListWrap-avatar" />
                
            </a>
            
        </div>
        
        <p class="cityListWrap-name"><?php echo $this->escape($v['city_name']); ?></a></p>
        
    </div>
    
    <?php } ?>
    
</div>

<?php } ?>