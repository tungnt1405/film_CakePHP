<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class MoviesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('movies');
        $this->setAlias('Movie');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasOne('MoviesInfo', [
            'foreignKey' => 'movie_id',
            'table' => 'movies_info',
            'alias' => 'MoviesInfo'
        ]);
        $this->hasMany('Comments', [
            'foreignKey' => 'movie_id',
            'table' => 'comments',
            'alias' => 'Comment'
        ]);
        $this->hasMany('Episodes', [
            'foreignKey' => 'movie_id',
            'table' => 'episodes',
            'alias' => 'Episode'
        ]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('m_name')
            ->maxLength('m_name', 255)
            ->requirePresence('m_name', 'create')
            ->notEmptyString('m_name');

        $validator
            ->scalar('m_slug')
            ->maxLength('m_slug', 255)
            ->requirePresence('m_slug', 'create')
            ->notEmptyString('m_slug');

        $validator
            ->scalar('m_desc')
            ->requirePresence('m_desc', 'create')
            ->notEmptyString('m_desc');

        return $validator;
    }

    public function getAllMovies()
    {
        $options = array(
            'field' => "*",
            "conditions" => array(
                'MoviesInfo.m_status =' => 1
            ),
            "contain" => array(
                "MoviesInfo"
            )
        );

        $data = $this->find("all", $options);

        return $data;
    }

    public function getCountAllMovies()
    {
        $options = array(
            'field' => "*",
            "conditions" => array(
                'MoviesInfo.m_status =' => 1
            ),
            "contain" => array(
                "MoviesInfo"
            )
        );

        $data = $this->find("all", $options)->count();

        return $data;
    }

    public function getMovieBySlug($slug)
    {
        $options = array(
            'field' => "*",
            "conditions" => array(
                'Movie.m_slug' => $slug
            ),
            "contain" => array(
                "MoviesInfo",
                "Episodes"
            )
        );

        $data = $this->find("all", $options)->first();

        return $data;
    }

    public function search($search)
    {
        $options = array(
            'field' => '*',
            'conditions' => array(
                'OR' => array(
                    array('Movie.m_name LIKE' => '%' . $search . '%'),
                    array('Movie.m_slug LIKE' => '%' . $search . '%'),
                    array('Movie.m_desc LIKE' => '%' . $search . '%'),
                )
            ),
            'contain' => [
                'MoviesInfo'
            ]
        );

        $data = $this->find('all', $options);
        return $data;
    }

    public function getAllMoviesRelatedByGenreID($genre_id)
    {
        $options = array(
            'field' => '*',
            'conditions' => [
                'MoviesInfo.m_status = ' => 1,
                'MoviesInfo.genre_id = ' => $genre_id,
            ],
            'contain' => [
                'MoviesInfo'
            ]
        );

        $data = $this->find('all', $options);

        return $data;
    }
    public function getAllMoviesRelatedByCategoryID($category_id)
    {
        $options = array(
            'field' => '*',
            'conditions' => [
                'MoviesInfo.m_status = ' => 1,
                'MoviesInfo.category_id = ' => $category_id,
            ],
            'contain' => [
                'MoviesInfo'
            ]
        );

        $data = $this->find('all', $options);

        return $data;
    }

    public function getMovieOfMonth($month_current, $year_current)
    {
        $options = [
            'fields' => ['created'],
            'conditions' => [
                'MONTH(Movie.created) =' => $month_current,
                'YEAR(Movie.created) =' => $year_current
            ],
            'contain' => "MoviesInfo"
        ];
        $data = $this->find('all', $options);
        return $data;
    }

    public function listMovies()
    {
        return $this->find('list', [
            'keyField' => 'id',
            'valueField' => 'm_name',
            'conditions' => [
                'MoviesInfo.m_status =' => 1
            ],
            'contain' => ['MoviesInfo']
        ]);
    }

    public function getMoviesByName($movie_name)
    {
        $options = [
            'field' => '*',
            'conditions' => [
                'OR' => [
                    'Movie.m_name LIKE' => '%' . $movie_name . '%',
                    'MoviesInfo.tags LIKE' => '%'.$movie_name.'%'
                ]
            ],
            'contain' => "MoviesInfo"
        ];
        $data = $this->find('all', $options);
        return $data;
    }
    public function getMoviesBySession($movie_name, $movie_sesson)
    {
        $options = [
            'field' => '*',
            'conditions' => [
                'Movie.m_name LIKE' => '%' . $movie_name . '%',
                'MoviesInfo.sesson <>' => $movie_sesson
            ],
            'contain' => "MoviesInfo"
        ];
        $data = $this->find('all', $options);
        return $data;
    }
}
