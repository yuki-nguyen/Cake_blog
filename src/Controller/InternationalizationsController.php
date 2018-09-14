<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\I18n;


class InternationalizationsController extends AppController{
   public function index(){
      if($this->request->is('post')){
         $locale = $this->request->data('international');
         I18n::locale($locale);
      }
   }
}
?>