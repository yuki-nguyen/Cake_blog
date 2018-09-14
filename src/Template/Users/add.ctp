<br>
<container>
<div class="index large-4 medium-4 large-offset-4 medium-offset-4 columns">
	<div class="panel">
		<h2 class="text-center">Please Register</h2>
		<?= $this->Form->create('User', array('id' => 'register')); ?>
            <fieldset>
                <legend><h6 class = "text-center"><?= __('Create new account') ?></h6></legend>
                    <?= $this->Form->input('username'); ?>
                    <?= $this->Form->input('email', array('type' => 'email')); ?>
                    <?= $this->Form->input('password', array('type' => 'password')); ?>
                    <?= $this->Form->input('password_confirm', array('type' => 'password')); ?>

                    <?= $this->Form->control('role', [
                        'options' => ['admin' => 'Admin', 'author' => 'Author']
                    ]) ?>
                    <?= $this->Form->button(__('Submit')); ?>
                    
            </fieldset>
            
            <?= $this->Form->end() ?>
	</div>
</div>
</container>

<script>
    $('#register').validate({
        rules: {
            'username': {
                required: true,
                minlength: 2,
                maxlength: 20,
            },
            
            'password': {
                required: true,
                minlength: 6,
                maxlength: 20,
            },
            'password_confirm': {
                equalTo: "#password"
            }
        },
        messages: {
            'username': {
                required: "Please enter username",
                minlength: "At least 2 characters",
                maxlength: "Maximum is 20 characters",
            },
            
            'password': {
                required: "Please enter password",
                minlength: "At least 6 characters",
                maxlength: "Maximum is 20 characters",
            },
            'password_confirm': {
                equalTo:"The password is not match",
            }
            
        },
    });
</script>