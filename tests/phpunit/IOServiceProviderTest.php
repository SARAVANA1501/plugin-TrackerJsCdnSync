<?php

namespace Piwik\Plugins\TrackerJsCdnSync\tests\phpunit;

use PHPUnit\Framework\TestCase;
use Piwik\Plugins\TrackerJsCdnSync\AwsS3\IOServiceForAwsS3;
use Piwik\Plugins\TrackerJsCdnSync\BunnyCdn\IOServiceForBunnyCdn;
use Piwik\Plugins\TrackerJsCdnSync\IOServiceProvider;

class IOServiceProviderTest extends TestCase
{

    public function testGetIOServiceForAws()
    {
        $config['type'] = 'aws-s3';
        $fileHandler = new IOServiceProvider($config);
        $ioService = $fileHandler->GetIOService();
        $this->assertEquals(new IOServiceForAwsS3($config), $ioService);
    }

    public function testGetIOServiceThrowExceptionForInvalidConfig()
    {
        $config['type'] = 'test-type';
        $fileHandler = new IOServiceProvider($config);

        $this->expectException(\Exception::class);
        $fileHandler->GetIOService();
    }
    public function testGetIOServiceThrowExceptionForInvalidConfigr()
    {
        $config['type'] = 'test-type';
        $fileHandler = new IOServiceProvider($config);

        $this->expectException(\Exception::class);
        $fileHandler->GetIOService();
    }
}
