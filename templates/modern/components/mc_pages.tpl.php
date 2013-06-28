<?php

$mc_pages = $this->getDataValue('content', 'mc_pages');

$disp = Dispatcher::getInstance();
$options = $disp->getOptions();

?>

<?php if(!empty($mc_pages['pages']) && count($mc_pages['pages']) > 1) { ?>

<div style="text-align:center; padding: 20px 1px;">
    
    <ul class="pagesList" >
        <?php if(!empty($mc_pages['prev'])) { ?>
        <li>
            
            <a href="<?php echo $this->getUrl(array('country' => $options['country'], 'section' => $options['section'], 'id' => $options['id'], 'page' => $mc_pages['prev'])); ?>" class="pagesList-prev"><</a>
            
        </li>
        <?php } ?>
        
        <?php foreach($mc_pages['pages'] as $k => $v) { ?>
    
        <li>
            
            <a href="<?php echo $this->getUrl(array('country' => $options['country'], 'section' => $options['section'], 'id' => $options['id'], 'page' => $v)); ?>" class="pagesList-page<?php echo $v == $mc_pages['current_page'] ? ' pagesList-current' : ''; ?>"><?php echo $v; ?></a>
            
        </li>
        
        <?php } ?>

        
        
        <?php if(!empty($mc_pages['next'])) { ?>
        <li>
            
            <a href="<?php echo $this->getUrl(array('country' => $options['country'], 'section' => $options['section'], 'id' => $options['id'], 'page' => $mc_pages['next'])); ?>" class="pagesList-next">></a>
            
        </li>
        <?php } ?>
        
    </ul>
    
</div>

<?php } ?>