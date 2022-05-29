<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class UsersBaseTable extends Table
{
 
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('users');
        $this->setAlias('User');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasOne("Profiles");
        $this->hasMany("Comments",[
            'foreignKey' => 'user_id',
            'table' => 'comments',
            'alias' => 'Comment'
        ]);
    }

    
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('name')
            ->maxLength('name', 50, 'Tên không vượt quá 50 ký tự')
            ->requirePresence('name', 'create')
            ->notEmptyString('name','Vui lòng không để trống tên');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmptyString('email','Vui lòng nhập email trước khi thêm')
            ->add('email', 'unique', [
                'rule' => 'validateUnique',
                'message' => 'Email này đã tồn tại',
                'provider' => 'table'
            ]);

        $validator
            ->boolean('email_verified')
            ->requirePresence('email_verified', 'create')
            ->notEmptyString('email_verified');

        $validator
            ->scalar('password')
            ->maxLength('password', 255)
            ->requirePresence('password', 'create')
            ->notEmptyString('password');

        $validator
            ->scalar('remember_token')
            ->maxLength('remember_token', 255)
            ->requirePresence('remember_token', 'create')
            ->notEmptyString('remember_token');

        $validator
            ->boolean('is_admin')
            ->requirePresence('is_admin', 'create')
            ->notEmptyString('is_admin');

        $validator
            ->scalar('role')
            ->maxLength('role', 10)
            ->requirePresence('role', 'create')
            ->notEmptyString('role', 'Vui lòng chọn quyền cho tài khoản');

        $validator
            ->boolean('active')
            ->requirePresence('active', 'create')
            ->notEmptyString('active');

        $validator
            ->boolean('status')
            ->requirePresence('status', 'create')
            ->notEmptyString('status');

        $validator
            ->dateTime('create_at')
            ->allowEmptyDateTime('create_at');

        $validator
            ->allowEmptyFile('img_avatar')
            // ->notEmptyString('img_avatar','Vui lòng chọn ảnh')
            ->add('img_avatar','file',[
                'rule' => array('chkImageExtension'),
            ]);

        return $validator;
    }

    
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['email']), ['errorField' => 'email','message'=>'Email đã tồn tại']);

        return $rules;
    }

    public function isValidRole($value, array $context): bool{
        return in_array($value, ['admin','member'], true);
    }

    public function chkImageExtension($data) {
        $return = true; 
 
        if($data['image']['name'] != ''){
             $fileData   = pathinfo($data['image']['name']);
             $ext        = $fileData['extension'];
             $allowExtension = array('gif', 'jpeg', 'png', 'jpg');
 
             if(in_array($ext, $allowExtension)) {
                 $return = true; 
             } else {
                 $return = false;
             }   
         } else {
             $return = false; 
         }   
 
         return $return;
     }  
}
