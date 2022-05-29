<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

class Moviesinfo extends Entity
{
    protected $_accessible = [
        'movie_id' => true,
        'category_id' => true,
        'country_id' => true,
        'genre_id' => true,
        'thumb' => true,
        'm_status' => true,
        'created' => true,
        'modified' => true,
        'movie' => true,
        'category' => true,
        'country' => true,
        'genre' => true,
        'resolution' => true,
        'subtitle' => true,
        'tags' => true,
        'session' =>true,
        'year' => true,
        'topview' => true,
        'sesson' => true,
        'total_episode'=>true
    ];
}
