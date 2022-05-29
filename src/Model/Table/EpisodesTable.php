<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class EpisodesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('episodes');
        $this->setAlias('Episode');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

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
            ->integer('episode')
            ->allowEmptyString('episode');

        $validator
            ->scalar('link_film')
            ->requirePresence('link_film', 'create')
            ->notEmptyString('link_film');

        return $validator;
    }

    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn('movie_id', 'Movies'), ['errorField' => 'movie_id']);

        return $rules;
    }

    public function getCountEpisodeOfMovie($id)
    {
        $options = array(
            'field' => '*',
            'order' => array('Episode.episode DESC', 'Episode.created DESC'),
            'conditions' => array(
                'Episode.movie_id =' => $id
            )
        );

        $data = $this->find('all', $options)->count();

        return $data;
    }

    public function getLinkEpisode($episode, $movie_id)
    {
        $option = array(
            'field' => '*',
            'conditions' => array(
                'OR' => array(
                    'Episode.episode =' => $episode,
                    'Episode.episode is ' => null,
                ),
                'Episode.movie_id =' => $movie_id
            )
        );

        $data = $this->find('all', $option)->first();
        return $data;
    }

    public function getMoviesHasLink()
    {
        $data = $this->find()->select(['movie_id_distinct' => 'DISTINCT (Episode.movie_id)'])->order(['movie_id_distinct' => 'DESC']);
        return $data;
    }

    public function search($search)
    {
        $options = array(
            'field' => '*',
            'conditions' => array(
                'Movies.m_name LIKE' => '%' . $search . '%'
            ),
            'order' => array(
                'Episode.id DESC',
                'Episode.created DESC'
            ),
            'contain' => [
                'Movies'
            ]
        );

        $data = $this->find('all', $options);
        return $data;
    }
}
