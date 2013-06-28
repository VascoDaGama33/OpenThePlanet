    <?php $head = $this->getDataValue('head'); ?>
    <title><?php echo $head['title']; ?></title>
    <meta charset="utf-8">
    <meta name="description" content="<?php echo $head['description']; ?>" />
    <meta name="keywords" content="<?php echo $head['keywords']; ?>" />
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo $this->tpl_rel_path ?>css/reset.css">
    <link rel='stylesheet' type='text/css' href='http://fonts.googleapis.com/css?family=Forum&subset=latin,cyrillic-ext' />
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo $this->tpl_rel_path ?>css/style.css">
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo $this->tpl_rel_path ?>css/grid_12.css">
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo $this->tpl_rel_path ?>css/slider.css">
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo $this->tpl_rel_path ?>css/jqtransform.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $this->tpl_rel_path ?>css/jquery.jcarousel.css">
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo $this->tpl_rel_path ?>css/jquery.fancybox.css?v=2.1.0" />
    <script src="<?php echo $this->tpl_rel_path ?>js/jquery-1.8.0.min.js"></script>
    <script src="<?php echo $this->tpl_rel_path ?>js/jquery.easing.1.3.js"></script>
    <script src="<?php echo $this->tpl_rel_path ?>js/mainmenu.js"></script>
    <script src="<?php echo $this->tpl_rel_path ?>js/up_button.js"></script>
    <script src="<?php echo $this->tpl_rel_path ?>js/tms-0.4.x.js"></script>
    <script src="<?php echo $this->tpl_rel_path ?>js/jquery.jqtransform.js"></script>
    <script src="<?php echo $this->tpl_rel_path ?>js/FF-cash.js"></script>
    <script type="text/javascript" src="<?php echo $this->tpl_rel_path ?>js/jquery.jcarousel.min.js"></script>
    <script type="text/javascript" src="<?php echo $this->tpl_rel_path ?>js/jquery.fancybox.js?v=2.1.0"></script>
    <script>
		$(document).ready(function(){
			$('.form-1').jqTransform();					   	
			$('.slider')._TMS({
				show:0,
				pauseOnHover:true,
				prevBu:'.prev',
				nextBu:'.next',
				playBu:false,
				duration:1000,
				preset:'fade',
				pagination:true,
				pagNums:false,
				slideshow:7000,
				numStatus:false,
				banners:false,
				waitBannerAnimation:false,
				progressBar:false
			});
                        $('.b-news UL').jcarousel({ 
                                scroll: 1,
                                auto: 5,
                                wrap: 'circular'
                        });
                        $(".fancybox").fancybox();
			   new Main_Menu();
			   new upButtonHandler();
		});
	</script>
	<!--[if lt IE 8]>
       <div style=' clear: both; text-align:center; position: relative;'>
         <a href="http://windows.microsoft.com/en-US/internet-explorer/products/ie/home?ocid=ie6_countdown_bannercode">
           <img src="http://storage.ie6countdown.com/assets/100/images/banners/warning_bar_0000_us.jpg" border="0" height="42" width="820" alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today." />
        </a>
      </div>
    <![endif]-->
    <!--[if lt IE 9]>
   	<script type="text/javascript" src="<?php echo $this->tpl_rel_path ?>js/html5.js"></script>
    	<link rel="stylesheet" type="text/css" media="screen" href="<?php echo $this->tpl_rel_path ?>css/ie.css">
    <![endif]-->
