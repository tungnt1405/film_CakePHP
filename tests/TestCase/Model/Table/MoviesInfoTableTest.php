<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MoviesinfoTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MoviesinfoTable Test Case
 */
class MoviesinfoTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\MoviesinfoTable
     */
    protected $Moviesinfo;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Moviesinfo',
        'app.Movies',
        'app.Category',
        'app.Country',
        'app.Genre',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Moviesinfo') ? [] : ['className' => MoviesinfoTable::class];
        $this->Moviesinfo = $this->getTableLocator()->get('Moviesinfo', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Moviesinfo);

        parent::tearDown();
    }
}
