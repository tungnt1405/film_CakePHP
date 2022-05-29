<?php
declare(strict_types=1);

use Migrations\AbstractSeed;
use Cake\Auth\DefaultPasswordHasher;
/**
 * Users seed.
 */
class UsersSeed extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeds is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     *
     * @return void
     */
    public function run()
    {
        $hasher = new DefaultPassWordHasher();
        $data = [];
        $faker = Faker\Factory::create();
        for ($i = 0; $i < 100; $i++) {
            $data[] = [
                'name'          => $faker->name,
                'email'         => $faker->unique()->email,
                'email_verified'=> '1',
                'password'      => $hasher->hash('Tg_140520'),
                'remember_token'=> $faker->sha1(),
                'is_admin'      => 0,
                'role'          => 'member',
                'active'        => 1,
                'status'        => 0,
                'create_at'     => Date('Y-m-d H:i:s'),
                'modified'      => Date('Y-m-d H:i:s'),
                'img_avatar'    => 'default.jpg'
            ];
        }
        $table = $this->table('users');
        $table->insert($data)->save();
    }
}
