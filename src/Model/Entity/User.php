<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Auth\DefaultPasswordHasher;

/**
 * User Entity
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $role
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 */
class User extends Entity
{

    
    protected $_accessible = [
        '*'   => true,
        'id'  => false
    ];

   
    protected $_hidden = [
        'password'
    ];

    protected function _setPassword($password)
    {
        if (strlen($password) >= 0) {
            return (new DefaultPasswordHasher)->hash($password);
        }
    }
}
