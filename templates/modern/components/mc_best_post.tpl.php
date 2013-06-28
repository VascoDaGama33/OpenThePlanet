<?php 
$mc_best_posts = $this->getDataValue('content', 'mc_best_posts'); 
//<div class="wrap block-1">
?>

<?php if(!empty($mc_best_posts) && is_array($mc_best_posts)) { ?>

<div class="component-wrap">
    
    <div class="b-news">
        
      <ul>

        <?php foreach($mc_best_posts as $id => $post) { ?>  

        <li>
            
            <div>

                <a href="<?php echo $this->getUrl(array('country' => $post['country_id'], 'section' => 2, 'id' => $post['id'])); ?>">

                    <img src="<?php echo $post['images']['AV']['image_path']; ?>" alt="<?php echo $this->escape($post['images']['AV']['alt']); ?>" class="jcarousel-imgAva">

                </a>

            </div>

            <div class="jcarousel-linkContainer">

                <a href="<?php echo $this->getUrl(array('country' => $post['country_id'], 'section' => 2, 'id' => $post['id'])); ?>" class="link">

                    <p><?php echo $this->escape($post['title']); ?></p>

                </a>

            </div>

            <div class="jcarousel-newsContainer"><?php echo $this->escape($post['prev_description']); ?></div>

        </li>

        <?php } ?>

      </ul>

    </div>

</div>

<?php } ?>
