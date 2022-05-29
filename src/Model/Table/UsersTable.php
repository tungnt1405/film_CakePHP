<?php

namespace App\Model\Table;

use App\Model\Table\UsersBaseTable;
use Cake\ORM\Query;

class UsersTable extends UsersBaseTable
{
    // hàm xử lý
    public function getCountAllUsers()
    {
        $options = array(
            'field' => '*',
            'conditions' => array(),
            'contain' => array(
                'Profiles'
            )
        );

        $data = $this->find('all', $options)->count();
        return $data;
    }

    public function search($search)
    {
        $options = array(
            'field' => '*',
            'conditions' => array(
                'OR' => array(
                    array('User.name LIKE' => '%' . $search . '%'),
                    array('User.email LIKE' => '%' . $search . '%'),
                    array('User.role LIKE' => '%' . $search . '%')
                )
            )
        );

        $data = $this->find('all', $options);
        return $data;
    }

    public function checkEmailUsers($email)
    {
        $options = [
            'conditions' => array(
                "User.email =" => $email,
            )
        ];
        $data = $this->find('all', $options)->first();
        return $data;
    }
}
