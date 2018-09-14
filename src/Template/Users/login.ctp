<?php
// use Cake\I18n\I18n;
// I18n::locale('en_US'); 
?>
<?php $this->assign('title', __('Login'));?>

<br>
<div class="menu">
  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Language
  </button>
    <p ><?= $this->Html->link("Japan", array("controller" => "App", "action" => "changeLanguage",'ja'),
                                    array(
                                            'escape' => false,
                                            'confirm' => 'Are you sure you want to change to Japan?'
                                    )); ?></p>
    <p><?= $this->Html->link("English", array("controller" => "App", "action" => "changeLanguage",'en'),
                                    array(
                                            'escape' => false,
                                            'confirm' => 'Are you sure you want to change to English?'
                                    )); ?></p>
    <p><?php
        $body = new \App\Controller\UsersController;
        $body->callAPI();
        ?></p>                               

</div>


<div class="index large-4 medium-4 large-offset-4 medium-offset-4 columns">
	<div class="panel">
		<h2 class="text-center"><?= __('Login') ?></h2>
                <?= $this->Flash->render() ?>
                <?= $this->Form->create('User', array('id' => 'login')); ?>
		            <fieldset>
                        <legend><h6><?= __('Enter your username and password') ?></h6></legend>
                            <?= $this->Form->control('username', ['label' => __('username')]) ?>
                            <?= $this->Form->control('password', ['label' => __('password')]) ?>

                            <?= $this->Form->button('Login'); ?>

                            
                        <p><?= __('Have no account?')?>
                            <?= $this->Html->link(__('Register'), ['action' => 'add']) ?></p>
                        
                        <p><?= __('Forgot your Password')?>
                            <?= $this->Html->link(__('Forgot your Password'), ['action' => 'password']) ?></p>
                    </fieldset>
                    <?= $this->Flash->render('auth') ?> <?= $this->Flash->render();?>
                    <?= $this->Form->end() ?> 
                    
    </div>
</div>
<script>

$(document).ready(function() {
    jQuery.validator.addMethod("noSpace", function(value, element) { 
        if(value.indexOf(" ") < 0 && value != ""){
            return true;
        }
        if(value.indexOf("　") < 0 && value != ""){
            return true;
        }   
        return false;
            }, "Space are not allowed" );

        })


    $('#login').validate({
        rules: {
            'username': {
                required: true,
                minlength: 2,
                maxlength: 20,
                noSpace: true,
                accept: true
            },
            
            'password': {
                required: true,
                minlength: 6,
                maxlength: 20,
            },
           
        },
        messages: {
            'username': {
                required: 'Please enter username',
                minlength: 'At least 2 characters',
                maxlength: 'Maximum is 20 characters',
                accept: 'No space',
            },
            
            'password': {
                required: 'Please enter password',
                minlength: 'At least 6 characters',
                maxlength: 'Maximum is 20 characters',
            },
            
            
        },
    });
</script>