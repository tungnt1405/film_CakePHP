<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class CountriesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('countries');
        $this->setAlias('Country');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('MoviesInfo', [
            'foreignKey' => 'country_id',
        ]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('country_name')
            ->maxLength('country_name', 255)
            ->requirePresence('country_name', 'create')
            ->notEmptyString('country_name');

        $validator
            ->scalar('country_slug')
            ->maxLength('country_slug', 255)
            ->requirePresence('country_slug', 'create')
            ->notEmptyString('country_slug');

        $validator
            ->scalar('country_description')
            ->requirePresence('country_description', 'create')
            ->notEmptyString('country_description');

        $validator
            ->boolean('country_status')
            ->requirePresence('country_status', 'create')
            ->notEmptyString('country_status');

        return $validator;
    }
    public function getSlugOfCountries($slug)
    {
        $options = [
            "field" => "*",
            "conditions" => [
                'Country.country_slug is' => $slug
            ],
            "order" => [
                'Country.id DESC'
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
                    array('Country.country_name LIKE' => '%' . $search . '%'),
                    array('Country.country_slug LIKE' => '%' . $search . '%'),
                )
            )
        );

        $data = $this->find('all', $options);
        return $data;
    }

    public function listCountry()
    {
        return $this->find('list', [
            'keyField' => 'id',
            'valueField' => 'country_name',
            'conditions' => [
                'Country.country_status <> 0'
            ],
            'recursive' => -1
        ]);
    }

    public function getMoviesByCountries($countryTitle, $idCount)
    {
        $joins = array(
            array(
                'table' => 'movies_info',
                'alias' => 'MoviesInfo',
                'type' => 'inner',
                'conditions' => [
                    'MoviesInfo.country_id =' => $idCount
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
            'fields' => ['Movie.id', 'Movie.m_name', 'Movie.thumb', 'Movie.m_slug', 'Country.country_name', 'Country.country_slug', 'Country.id', 'MoviesInfo.resolution'],
            'conditions' => array(
                'OR' => [
                    "Country.country_name =" => $countryTitle,
                    "Country.id =" => $idCount
                ],
                "MoviesInfo.m_status =" => 1
            ),
            'order' => [
                'Country.modified' => 'desc'
            ],
        );
        $data = $this->find('all', $options)->join($joins);

        return $data;
    }
}
