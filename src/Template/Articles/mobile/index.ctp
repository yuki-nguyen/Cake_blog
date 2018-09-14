<?php $this->assign('title', $this->Session->read('Auth.User.username'));?>
<h2><i>Blog articles</i></h2>
<div class="table-responsive">
    <p><?= $this->Html->link('Add Article', ['action' => 'add']) ?></p>
    <table class="table table-hover">
         <thead class="thead-dark">
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Title</th>
                <th scope="col">Created</th>
                <th scope="col">Actions</th>
         </tr>
        </thread>
        <tbody>

         <?php foreach ($articles as $article): ?>
        <!-- <tr onclick="window.location='#';">  -->
        <tr class = "checkbox" id = <?= "row_". $article->id ?>  >
            <th scope="row"><?= $article->id ?></th>
        
            <td>
                <?= $this->Html->link($article->title, ['action' => 'view', $article->id]) ?>
            </td>
            <td>
                <?= $article->created->format(DATE_RFC850) ?>
            </td>
            <td >
                <!-- <?= $this->Form->postLink(
                    'Delete',
                    ['action' => 'delete', $article->id],
                    ['confirm' => 'Are you sure?'])
                ?>
                ||  -->
                

                <a class="delete-it text-danger " id=<?php echo $article->id; ?>>Delete </delete>   </a>
                
                ||

                <?= $this->Html->link('Edit', ['action' => 'edit', $article->id]) ?>
            </td>
        </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>


<script>
    $(document).on('click', '.delete-it', function() {
        
        var id = $(this).attr('id');
        
        var answer = confirm("Are you sure to delete this: " + id + "?")

        var csrfToken = <?= json_encode($this->request->getParam('_csrfToken')) ?>;
       
            if (answer) {
                $.ajax({
                    type: "DELETE",
                    
                    url: '<?= $this->Url->build(["action" => "delete"]) ?>/'+id,
                    headers : {
                        'X-CSRF-Token': csrfToken
                                },
                    data: {
                        id: id,
                    },
                    dataType: 'json',
                    success: function (response) {
                        if(response.result == "success") {
                            console.log('success');
                            $('#row_'+id).remove();
                        } 
                        else if(response.result === "error") {
                            console.log('error');
                        }
                    }
  
                });
                
            }
        
        return false;
    });
</script>




