<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * MoviesinfoFixture
 */
class MoviesinfoFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'movies_info';
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
                'movie_id' => 1,
                'category_id' => 1,
                'country_id' => 1,
                'genre_id' => 1,
                'thumb' => 'Lorem ipsum dolor sit amet',
                'm_status' => 1,
                'created' => '2022-03-14',
                'modified' => '2022-03-14',
            ],
        ];
        parent::init();
    }
}
