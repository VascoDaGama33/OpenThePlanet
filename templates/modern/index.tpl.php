<!DOCTYPE html>
<html>
    <head>    
        <?php echo $this->loader($this->head); ?>
    </head>
    <body>
        <div class="main">
            <header>
                <div>
                    <!--==============================header=================================-->
                    <?php echo $this->loader($this->header); ?>
                </div>
            </header>

            <section id="content">
                <div class="container_12">
                    <!--==============================content================================-->
                    <?php echo $this->loader($this->content); ?>
                </div>  
            </section> 
        </div>
        <footer>
            <!--==============================footer=================================-->
            <?php echo $this->loader($this->footer); ?>
        </footer>
    </body>
</html>  
