<?php
declare(strict_types=1);

namespace App\View\Helper;

use Cake\View\Helper;
use Cake\View\View;

/**
 * Admin helper
 */
class AdminHelper extends Helper
{
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];
    public $helpers =['Html'];
    public function showPagination()
    {
        $pagination = 'hihi';
        return $pagination;
    }

}
