<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class ProfilesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('profiles');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
        ]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->integer('phone')
            ->requirePresence('phone', 'create')
            ->notEmptyString('phone');

        $validator
            ->scalar('address_city')
            ->maxLength('address_city', 255)
            ->requirePresence('address_city', 'create')
            ->notEmptyString('address_city');

        $validator
            ->scalar('address_district')
            ->maxLength('address_district', 255)
            ->requirePresence('address_district', 'create')
            ->notEmptyString('address_district');

        $validator
            ->scalar('link_social1')
            ->allowEmptyString('link_social1');

        $validator
            ->scalar('link_social2')
            ->allowEmptyString('link_social2');

        return $validator;
    }

    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn('user_id', 'Users'), ['errorField' => 'user_id']);

        return $rules;
    }

    public function getProfileOfUserId($userId = null)
    {
        $options = [
            'filed' => '*',
            'conditions' => [
                'Profiles.user_id' => $userId
            ]
        ];

        $data = $this->find('all', $options)->first();
        return $data;
    }
}
