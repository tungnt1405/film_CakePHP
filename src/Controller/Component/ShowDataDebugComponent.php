<?php

declare(strict_types=1);

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;

class ShowDataDebugComponent extends Component
{
    protected $_defaultConfig = [];

    public function dd($param)
    {
        echo "<pre>";
        echo json_encode($param);
        echo "</pre>";
        die;
    }
    public function ddd($param)
    {
        echo "<pre>";
        print_r($param);
        echo "</pre>";
        die;
    }
    public function d_4($param)
    {
        echo "<pre>";
        var_dump($param);
        echo "</pre>";
        die;
    }
}
