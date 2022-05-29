<?php
declare(strict_types=1);

namespace App\Test\TestCase\View\Helper;

use App\View\Helper\AdminHelper;
use Cake\TestSuite\TestCase;
use Cake\View\View;

/**
 * App\View\Helper\AdminHelper Test Case
 */
class AdminHelperTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\View\Helper\AdminHelper
     */
    protected $Admin;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $view = new View();
        $this->Admin = new AdminHelper($view);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Admin);

        parent::tearDown();
    }
}
