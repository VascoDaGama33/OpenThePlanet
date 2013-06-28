<?php 
$disp = Dispatcher::getInstance();
$options = $disp->getOptions();

$header = $this->getDataValue('header'); 

?>

<h1 class="siteLogo"><a href="<?php echo OTP_HOST; ?>"><img src="/images/_main/logo.jpg" alt=""></a></h1>

<?php if(!empty($header['country_logo'])) { ?>

    <h1  class="siteLogoCountry"><a href="<?php echo $this->getUrl(array('country' => $header['country_logo']['country_id'])); ?>"><img src="<?php echo $header['country_logo']['image_path']; ?>" alt=""></a></h1>

<?php } ?>

<div class="social-icons"></div>


<div id="slide">
    
    <div class="slider">
        
        <ul class="items">
            <?php if(!empty($header['slider'])) { ?>
            
            <?php foreach($header['slider'] as $k => $v) { ?>
            
                <li><img src="<?php echo $v['image_path'] ?>" alt="<?php echo $v['alt']; ?>" /></li>
                
            <?php }; ?>
                
            <?php } ?>
                
        </ul>
        
    </div>
    
    <a href="#" class="prev"></a><a href="#" class="next"></a>
    
</div>


<?php if(!empty($header['categories'])) { ?>

<nav>
    
    <ul class="menu" id="nav_menu">
        
        <?php foreach($header['categories'] as $k => $v) { ?>
        
            <?php if(!empty($v['menu']) && is_array($v['menu'])) { ?>
        
                <li<?php echo $options['section'] == $v['menu']['section_id'] ? ' class="current"' : ''; ?>>
                    
                    <div class="nav-menu-item">
                    
                        <a href="<?php echo $this->getUrl(array('country' => $options['country'], 'section' => $v['menu']['section_id'])); ?>"><?php echo $this->escape($v['menu']['category_name']); ?></a>
                    
                        <?php if(!empty($v['sub_menu'])) { ?>
                    
                        <div class="sub_menu">

                            <ul>
                        
                            <?php foreach($v['sub_menu'] as $k_sub => $v_sub) { ?>
                            
                                <li><a href="<?php echo $this->getUrl($v_sub['link_data']); ?>"><?php echo $this->escape($v_sub['name']); ?></a></li>
                            
                            <?php } ?>

				</ul>
                                
                            <div style="clear: both;"></div>
                                
                            <div class="sub_menu_all">
                                
                                <a href="<?php echo $this->getUrl(array('country' => $options['country'], 'section' => $v['menu']['section_id'])); ?>">Перейти в категорию &quot;<i><?php echo $this->escape($v['menu']['category_name']); ?></i>&quot;</a>
                                
                            </div>
                        
                        </div>
                    
                        <?php } ?>
                    
                    </div>
                    
                </li>
       
            <?php } ?>
                
         <?php } ?>       
            
    </ul>
    
</nav>

<?php } ?>                        
               