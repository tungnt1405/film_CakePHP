<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

class Movie extends Entity
{
    protected $_accessible = [
        'm_name' => true,
        'm_slug' => true,
        'm_desc' => true,
        'movies_info' => true,
        'episodes' => true,
        'comments' =>true,
        'created' => true,
        'modified' => true,
    ];
}
