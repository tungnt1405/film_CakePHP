<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Component;

use App\Controller\Component\AWSComponent;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Component\AWSComponent Test Case
 */
class AWSComponentTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Controller\Component\AWSComponent
     */
    protected $AWS;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->AWS = new AWSComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->AWS);

        parent::tearDown();
    }
}
