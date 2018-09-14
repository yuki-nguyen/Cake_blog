<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Articles Controller
 *
 * @property \App\Model\Table\ArticlesTable $Articles
 *
 * @method \App\Model\Entity\Article[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ArticlesController extends AppController
{

    
    public function index()
    {
        $articles = $this->Articles->find('all');

        $this->set(compact('articles'));
    }
    

    
    public function view($id = null)
    {
        $article = $this->Articles->get($id);

        $this->set(compact('article'));
    }

    public function add()
    {
        $article = $this->Articles->newEntity();
        if ($this->request->is('post')) {
            $article = $this->Articles->patchEntity($article, $this->request->getData());

            $article->user_id = $this->Auth->user('id');
        
            if ($this->Articles->save($article)) {
                $this->Flash->success(__('Your article has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add your article.'));
        }
        $this->set('article', $article);

        // $categories = $this->Articles->Categories->find('treeList');
        // $this->set(compact('categories'));

    }
    
    public function edit($id = null)
    {
        $article = $this->Articles->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $article = $this->Articles->patchEntity($article, $this->request->getData());
            if ($this->Articles->save($article)) {
                $this->Flash->success(__('The article has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The article could not be saved. Please, try again.'));
        }
        $this->set(compact('article'));
    }

    
    public function delete($id)
    {

        //$this->request->allowMethod(['post', 'delete']);
        if($id == ""|| $id == null){
            $id = $this->request->data["id"];
        }
        // var_dump($id);exit;
        $article = $this->Articles->get($id);     

        if ($this->Articles->delete($article)) {

            // $this->Flash->success(__('The article with id: {1} has been deleted.', h($id)));
            
            // $this->autoRender = false;
            $response = array('result' => 'success');
            
            // $this->set('_serialize', 'article');

            // return $this->redirect(['action' => 'index']);
        }else {
            // $this->Flash->error(__('The location could not be saved. Please, try again.'));
            $response =array('result' => 'error');
        }
        // $this->set(compact('article'));
        // $this->set('_serialize', ['article']);
        $this->renderJson($response);
    }

    public function isAuthorized($user)
    {
    
        if ($this->request->getParam('action') === 'add') {
            return true;
        }

    
        if (in_array($this->request->getParam('action'), ['edit', 'delete'])) {
        
            $articleId = (int)$this->request->getParam('pass.0');
            
            if ($this->Articles->isOwnedBy($articleId, $user['id'])) {
                
                return true;
            } else{
                return false;
            }
        }

        return parent::isAuthorized($user);
    }

    public function renderJson($data)
    {
        $this->autoRender = false;
        $this->response->body(json_encode($data));
        $this->response->type('application/json');

        return $this->response;
    }
    }
