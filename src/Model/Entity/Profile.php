<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

class Profile extends Entity
{
    protected $_accessible = [
        'user_id' => true,
        'phone' => true,
        'address_city' => true,
        'address_district' => true,
        'link_social1' => true,
        'link_social2' => true,
        'created' => true,
        'modified' => true,
        'user' => true,
    ];
}
