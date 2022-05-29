<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class MoviesinfoTable extends Table
{
    function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('movies_info');
        $this->setAlias('MoviesInfo');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Movies', [
            'foreignKey' => 'movie_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Categories', [
            'foreignKey' => 'category_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Countries', [
            'foreignKey' => 'country_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Genres', [
            'foreignKey' => 'genre_id',
            'joinType' => 'INNER',
        ]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('thumb')
            ->maxLength('thumb', 255)
            ->allowEmptyString('thumb');

        $validator
            ->boolean('m_status')
            ->requirePresence('m_status', 'create')
            ->notEmptyString('m_status');

        return $validator;
    }

    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn('movie_id', 'Movies'), ['errorField' => 'movie_id']);
        $rules->add($rules->existsIn('category_id', 'Categories'), ['errorField' => 'category_id']);
        $rules->add($rules->existsIn('country_id', 'Countries'), ['errorField' => 'country_id']);
        $rules->add($rules->existsIn('genre_id', 'Genres'), ['errorField' => 'genre_id']);

        return $rules;
    }
    public function getTopTuanByMovie()
    {
        $options = [
            'field' => '*',
            'conditions' => [
                'MoviesInfo.topview = ' => 'tuan',
                'MoviesInfo.m_status =' => 1
            ],
            'contain' => [
                'Movies',
                'Categories',
                'Genres',
                'Countries'
            ],
            'limit' => 4,
            'order' => [
                'MoviesInfo.modified DESC',
                'MoviesInfo.created DESC',
                'MoviesInfo.id DESC'
            ]
        ];

        return $this->find('all', $options);
    }
    public function getTopThangByMovie()
    {
        $options = [
            'field' => '*',
            'conditions' => [
                'MoviesInfo.topview = ' => 'thang',
                'MoviesInfo.m_status =' => 1
            ],
            'contain' => [
                'Movies',
                'Categories',
                'Genres',
                'Countries'
            ],
            'limit' => 4,
            'order' => [
                'MoviesInfo.modified DESC',
                'MoviesInfo.created DESC',
                'MoviesInfo.id DESC'
            ]
        ];

        return $this->find('all', $options);
    }

    public function getTopNamByMovie()
    {
        $options = [
            'field' => '*',
            'conditions' => [
                'MoviesInfo.topview = ' => 'nam',
                'MoviesInfo.m_status =' => 1
            ],
            'contain' => [
                'Movies',
                'Categories',
                'Genres',
                'Countries'
            ],
            'limit' => 4,
            'order' => [
                'MoviesInfo.modified DESC',
                'MoviesInfo.created DESC',
                'MoviesInfo.id DESC'
            ]
        ];

        return $this->find('all', $options);
    }

    public function getMoviesByYear($year)
    {
        $options = [
            'field' => '*',
            'conditions' => [
                'MoviesInfo.year = ' => $year,
                'MoviesInfo.m_status =' => 1
            ],
            'contain' => [
                'Movies',
                'Categories',
                'Genres',
                'Countries'
            ],
            'order' => [
                'MoviesInfo.modified DESC',
                'MoviesInfo.created DESC',
                'MoviesInfo.id DESC'
            ]
        ];

        return $this->find('all', $options);
    }
}
