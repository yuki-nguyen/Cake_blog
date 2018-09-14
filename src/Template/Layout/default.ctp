<?php

$cakeDescription = 'CakePHP: the rapid development php framework';
?>
<!DOCTYPE html>
<html >
<head>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>


    <?= $this->Html->css('bootstrap.min.css') ?>
    <?= $this->Html->css('sticky-footer-navbar.css') ?>    
    <?= $this->Html->css('base.css') ?>
   

    <?= $this->Html->script('jquery-3.3.1.min.js') ?>
    <?= $this->Html->script('jquery.validate.min.js') ?>
    <?= $this->Html->script('bootstrap.min.js') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>

     <div class="container">
      <!-- Fixed navbar -->
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">

            <a class="navbar-brand" href=""><?= $this->fetch('title') ?></a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            

            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav mr-auto">
                    
                </ul>
                
                <?php
                    if($this->Session->read('Auth')) {
                        // user is logged in, show logout..user menu etc
                    echo $this->Html->link('Logout', array('controller' => 'users', 'action' => 'logout'));
                    // echo $this->Session->read('Auth.User.username');
                    } else {
                        // the user is not logged in
                    echo $this->Html->link('Login', array('controller' => 'users', 'action' => 'login')); 
                    }
                ?>
                
            </div>
            
        </nav>
        <?= $this->Flash->render() ?>
                

    <!-- Begin page content -->
    <main role="main" class="container clearfix">
        <p class="lead"><?= $this->fetch('content') ?></p>
    </main>

 
 </div>
</body>

</html>
