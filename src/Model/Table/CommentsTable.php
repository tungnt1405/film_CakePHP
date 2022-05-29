<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class CommentsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('comments');
        $this->setAlias('Comment');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Movies', [
            'foreignKey' => 'movie_id',
            'joinType' => 'INNER',
        ]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('content')
            ->requirePresence('content', 'create')
            ->notEmptyString('content');

        return $validator;
    }

    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn('user_id', 'Users'), ['errorField' => 'user_id']);
        $rules->add($rules->existsIn('movie_id', 'Movies'), ['errorField' => 'movie_id']);

        return $rules;
    }

    public function search($search)
    {
        $joins = array(
            array(
                'table' => 'users',
                'alias' => 'User',
                'type' => 'inner',
                'conditions' => [
                    'User.id = Comment.user_id'
                ]
            ),
            array(
                'table' => 'movies',
                'alias' => 'Movie',
                'type' => 'inner',
                'conditions' => [
                    'Movie.id = Comment.movie_id'
                ]
            ),
        );
        $options = array(
            'field' => '*',
            'conditions' => array(
                'OR' => array(
                    array('User.name LIKE' => '%' . $search . '%'),
                    array('Movie.m_name LIKE' => '%' . $search . '%'),
                )
            ),
            'contain' => ['Users', 'Movies']
        );

        $data = $this->find('all', $options)->join($joins);
        return $data;
    }

    public function avgRatingOfMovie($id_movie)
    {
        return $this->find('all', [
            'conditions' => [
                'Comment.movie_id = ' => $id_movie
            ],
            'order' => [
                'Comment.created DESC'
            ]
        ])->all()->avg('rate');
    }

    public function getCommentOfMovies($id_movie)
    {
        return $this->find('all', [
            'conditions' => [
                'Comment.movie_id = ' => $id_movie
            ],
            'contain' => ['Users', 'Movies']
        ]);
    }
}
