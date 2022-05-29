<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

class Episode extends Entity
{
    protected $_accessible = [
        'movie_id' => true,
        'episode' => true,
        'link_film' => true,
        'created' => true,
        'modified' => true,
        'movie' => true,
    ];
}
