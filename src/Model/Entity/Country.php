<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

class Country extends Entity
{
    protected $_accessible = [
        'country_name' => true,
        'country_slug' => true,
        'country_description' => true,
        'country_status' => true,
        'created' => true,
        'modified' => true,
    ];
}
