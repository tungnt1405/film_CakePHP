<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class GenresTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('genres');
        $this->setAlias('Genre');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('MoviesInfo', [
            'foreignKey' => 'genre_id',
        ]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('title')
            ->maxLength('title', 255)
            ->requirePresence('title', 'create')
            ->notEmptyString('title');

        $validator
            ->scalar('slug')
            ->maxLength('slug', 255)
            ->requirePresence('slug', 'create')
            ->notEmptyString('slug');

        $validator
            ->scalar('description')
            ->requirePresence('description', 'create')
            ->notEmptyString('description');

        $validator
            ->boolean('status')
            ->requirePresence('status', 'create')
            ->notEmptyString('status');

        return $validator;
    }


    public function getAllOfGenre()
    {
        $options = array(
            'field' => '*',
            'order' => array(
                'Genre.modified DESC'
            ),
            'conditions' => array(
                'Genre.status =' => 1
            )
        );

        $data = $this->find('all', $options);

        return $data;
    }

    public function getCountAllGenres()
    {
        $options = array(
            'field' => '*',
            'conditions' => array(
                'Genre.status =' => 1
            )
        );

        $data = $this->find('all', $options)->count();

        return $data;
    }

    public function getSlugOfGenres($slug)
    {
        $options = [
            "field" => "*",
            "conditions" => [
                'Genre.slug' => $slug
            ],
            "order" => [
                'Genre.id DESC'
            ]
        ];

        $data = $this->find('all', $options)->first();

        return $data;
    }

    public function search($search)
    {
        $options = array(
            'field' => '*',
            'conditions' => array(
                'OR' => array(
                    array('Genre.title LIKE' => '%' . $search . '%'),
                    array('Genre.slug LIKE' => '%' . $search . '%'),
                )
            )
        );

        $data = $this->find('all', $options);
        return $data;
    }

    public function listGenres()
    {
        return $this->find('list', [
            'keyField' => 'id',
            'valueField' => 'title',
            'conditions' => [
                'status <> 0'
            ],
            'recursive' => -1
        ]);
    }

    public function getMoviesByGenre($genreTitle, $idGen)
    {
        $joins = array(
            array(
                'table' => 'movies_info',
                'alias' => 'MoviesInfo',
                'type' => 'inner',
                'conditions' => [
                    'MoviesInfo.genre_id =' => $idGen
                ]
            ),
            array(
                'table' => 'movies',
                'alias' => 'Movie',
                'type' => 'inner',
                'conditions' => [
                    'Movie.id = MoviesInfo.movie_id'
                ]
            ),
        );

        $options = array(
            'fields' => ['Movie.id', 'Movie.m_name', 'Movie.m_slug', 'Movie.thumb', 'Genre.title', 'Genre.slug', 'Genre.id', 'MoviesInfo.resolution'],
            'conditions' => array(
                'OR' => [
                    "Genre.title =" => $genreTitle,
                    "Genre.id =" => $idGen
                ],
                "MoviesInfo.m_status =" => 1
            ),
            'order' => [
                'Genre.modified' => 'desc'
            ],
        );
        $data = $this->find('all', $options)->join($joins);

        return $data;
    }
}
