<?php
declare(strict_types=1);

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Aws\S3\S3Client;

class AWSComponent extends Component
{
    public $config = null;
    public $s3 = null;

    public function initialize(array $config):void{
        parent::initialize($config);
        $this->config = [
           's3' => [
               'key' => 'AKIAT4OBY7NOQDVMDDIK',
               'secret' => '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',
               'bucket' => 'pj-movies',
           ]
        ];
        $this->s3 = S3Client::factory([
            'credentials' => [
               'key' => $this->config['s3']['key'],
               'secret' => $this->config['s3']['secret']
            ],
        'region' => 'ap-southeast-1',
        'version' => 'latest'
        ]);
    }
}
