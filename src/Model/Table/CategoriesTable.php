<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class CategoriesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('categories');
        $this->setAlias("Category");
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('MoviesInfo', [
            'foreignKey' => 'category_id',
            'table' => 'movies_info',
            'alias' => 'MoviesInfo'
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

    public function getCountAllCategories()
    {
        $options = array(
            'field' => '*',
            'conditions' => array(
                'Category.status =' => 1
            )
        );

        $data = $this->find('all', $options)->count();

        return $data;
    }

    public function getSlugOfCategories($slug)
    {
        $options = [
            "field" => "*",
            "conditions" => [
                'Category.slug' => $slug
            ],
            "order" => [
                'Category.id DESC'
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
                    array('Category.title LIKE' => '%' . $search . '%'),
                    array('Category.slug LIKE' => '%' . $search . '%'),
                )
            )
        );

        $data = $this->find('all', $options);
        return $data;
    }

    public function listCategory()
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

    public function getMoviesByCategory($categoryTitle, $idCate)
    {
        $joins = array(
            array(
                'table' => 'movies_info',
                'alias' => 'MoviesInfo',
                'type' => 'inner',
                'conditions' => [
                    'MoviesInfo.category_id =' => $idCate
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
            'fields' => ['Movie.id', 'Movie.m_name', 'Movie.m_slug', 'Movie.thumb', 'Category.title', 'Category.slug', 'Category.id', 'MoviesInfo.resolution'],
            'conditions' => array(
                'OR' => [
                    "Category.title =" => $categoryTitle,
                    "Category.id =" => $idCate
                ],
                "MoviesInfo.m_status =" => 1
            ),
            'order' => [
                'Category.modified' => 'desc'
            ],
        );
        $data = $this->find('all', $options)->join($joins);

        return $data;
    }
}
