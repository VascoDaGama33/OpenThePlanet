<div class="grid_8">
    
    <?php 
    
    foreach($this->main_components as $k => $v) {
        
        echo $this->loader($v);
        
    }
    
    ?>
    
</div>

<div class="grid_4">
    
    <div class="left-1">
    
    <?php 
    
    foreach($this->extra_components as $k => $v) {
        
        echo $this->loader($v);
        
    }
    
    ?>
        
    </div>
    
</div>

<div class="clear"></div>


