<?php


namespace Piwik\Plugins\TrackerJsCdnSync;

use Piwik\Plugins\TrackerJsCdnSync\AwsS3\IOServiceForAwsS3;
use Piwik\Plugins\TrackerJsCdnSync\BunnyCdn\IOServiceForBunnyCdn;

class IOServiceProvider
{
    private $config;

    function __construct($config)
    {
        $this->config = $config;
    }

    public function GetIOService()
    {
        switch ($this->config['type']) {
            case 'aws-s3':
                return new IOServiceForAwsS3($this->config);
                break;
            case 'bunny-cdn':
                return new IOServiceForBunnyCdn($this->config);
                break;
            default:
                throw new \Exception('Invalid argument: CDN Type');
        }
    }
}