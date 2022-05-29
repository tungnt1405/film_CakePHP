<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * User Entity
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property bool $email_verified
 * @property string $password
 * @property string $remember_token
 * @property bool $is_admin
 * @property string $role
 * @property bool $active
 * @property bool $status
 * @property \Cake\I18n\FrozenTime|null $create_at
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property string|null $img_avatar
 */
class User extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'name' => true,
        'email' => true,
        'email_verified' => true,
        'password' => true,
        'remember_token' => true,
        'is_admin' => true,
        'role' => true,
        'active' => true,
        'status' => true,
        'profile' => true,
        // 'create_at' => false,
        // 'modified' => false,
        'img_avatar' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password',
        'create_at',
        'modified'
    ];
}
