<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Component;

use App\Controller\Component\ShowDataDebugComponent;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Component\ShowDataDebugComponent Test Case
 */
class ShowDataDebugComponentTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Controller\Component\ShowDataDebugComponent
     */
    protected $ShowDataDebug;

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->ShowDataDebug = new ShowDataDebugComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->ShowDataDebug);

        parent::tearDown();
    }
}
