<?php


namespace Piwik\Plugins\TrackerJsCdnSync;

use Piwik\Plugins\TrackerJsCdnSync\AwsS3\IOServiceForAwsS3;

class IOServiceProvider
{
    private $config;

    function __construct($config)
    {
        $this->config = $config;
    }

    public function GetIOService(): IOService
    {
        switch ($this->config['type']) {
            case 'aws-s3':
                return new IOServiceForAwsS3($this->config);
                break;
            default:
                throw new \Exception('Invalid argument: CDN Type');
        }
    }
}