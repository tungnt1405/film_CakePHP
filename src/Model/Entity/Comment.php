<?php

declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

class Comment extends Entity
{
    protected $_accessible = [
        'user_id' => true,
        'movie_id' => true,
        'content' => true,
        'created' => true,
        'modified' => true,
        'users_base' => true,
        'movie' => true,
        'rate' => true
    ];
}
