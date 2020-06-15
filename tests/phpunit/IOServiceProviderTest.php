<?php

namespace Piwik\Plugins\TrackerJsCdnSync;

use PHPUnit\Framework\TestCase;
use Piwik\Plugins\TrackerJsCdnSync\AwsS3\IOServiceForAwsS3;

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
