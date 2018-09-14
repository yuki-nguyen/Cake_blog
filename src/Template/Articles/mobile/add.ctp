<h1>Add Article</h1>
<?php
    echo $this->Form->create($article);
    echo $this->Form->control('title');
    //echo $this->Form->control('title', array('type'=>'text', 'label'=>'title')); //you can change type or name of lable
    echo $this->Form->control('body', ['rows' => '3']);
    echo $this->Form->button(__('Add Articles'));
    echo $this->Form->end();
?>