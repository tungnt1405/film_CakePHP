<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UsersFixture
 */
class UsersFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'name' => 'Lorem ipsum dolor sit amet',
                'email' => 'Lorem ipsum dolor sit amet',
                'email_verified' => 1,
                'password' => 'Lorem ipsum dolor sit amet',
                'remember_token' => 'Lorem ipsum dolor sit amet',
                'is_admin' => 1,
                'role' => 'Lorem ip',
                'active' => 1,
                'status' => 1,
                'create_at' => '2022-02-28 13:58:44',
                'modified' => '2022-02-28 13:58:44',
                'img_avatar' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
