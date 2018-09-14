<?php

$cakeDescription = 'CakePHP: the rapid development php framework';
?>
<!DOCTYPE html>
<html >
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css('base.css') ?>
    <!-- <?= $this->Html->css('style.css') ?> -->
    <?= $this->Html->css('bootstrap.min.css') ?>
    <?= $this->Html->css('sticky-footer-navbar.css') ?>    

    <?= $this->Html->script('jquery-3.3.1.min.js') ?>
    <?= $this->Html->script('jquery.validate.min.js') ?>
    <?= $this->Html->script('bootstrap.min.js') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>

    <header>
      <!-- Fixed navbar -->
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">

            <a class="navbar-brand" href=""><?= $this->fetch('title').'-Mobile'?></a>

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
    </header>

    <!-- Begin page content -->
    <main role="main" class="container">
        <p class="lead"><?= $this->fetch('content') ?></p>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-copyright text-center py-3">© Made with love by : TuyetNguyen
            </div>
        </div>
    </footer>

</body>

</html>
