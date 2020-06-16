<?php

namespace Piwik\Plugins\TrackerJsCdnSync\AwsS3;

use Aws\S3\S3Client;
use PHPUnit\Framework\TestCase;

class IOServiceForAwsS3Test extends TestCase
{

    public function testAddFile()
    {
        $config['type'] = 'aws-s3';
        $config['auth-type'] = 'IAM-Role';
        $config['bucket'] = 'Test-Bucket';
        $config['version'] = 'latest';
        $config['region'] = 'Test-Region';
        $file = 'test.js';

        $awsClient_1 = $this->getMockBuilder(S3Client::class)
            ->addMethods(['putObject'])
            ->disableOriginalConstructor()
            ->getMock();

        $awsClient_1->expects($this->once())->method('putObject')->with([
            'Bucket' => $config['bucket'],
            'Key' => basename($file),
            'SourceFile' => $file
        ]);

        $s3 = new MockIOServiceForS3($awsClient_1, $config);
        $s3->AddFile($file);
    }

    public function testDeleteFile()
    {
        $config['type'] = 'aws-s3';
        $config['auth-type'] = 'IAM-Role';
        $config['bucket'] = 'Test-Bucket';
        $config['version'] = 'latest';
        $config['region'] = 'Test-Region';
        $file = 'test.js';

        $awsClient_1 = $this->getMockBuilder(S3Client::class)
            ->addMethods(['deleteObject'])
            ->disableOriginalConstructor()
            ->getMock();

        $awsClient_1->expects($this->once())->method('deleteObject')->with([
            'Bucket' => $config['bucket'],
            'Key' => basename($file)
        ]);

        $s3 = new MockIOServiceForS3($awsClient_1, $config);
        $s3->DeleteFile($file);
    }

    public function testGetClientWithRoleBasedAccess()
    {
        $config['type'] = 'aws-s3';
        $config['auth-type'] = 'IAM-Role';
        $config['Bucket'] = '';
        $config['version'] = 'latest';
        $config['region'] = '';
        $expectedClient = new S3Client([
            'region' => $config['region'],
            'version' => $config['version']
        ]);

        $awsClient = new IOServiceForAwsS3($config);

        $this->assertEquals($expectedClient, $awsClient->GetClient());
    }

    public function testGetClientWithIAMUserAccess()
    {
        $config['type'] = 'aws-s3';
        $config['auth-type'] = 'IAM-User';
        $config['bucket'] = 'my-bucket';
        $config['version'] = 'latest';
        $config['region'] = 'my-region';
        $config['key'] = 'my-access-key-id';
        $config['secret'] = '';
        $expectedClient = new S3Client([
            'region' => $config['region'],
            'version' => $config['version'],
            'credentials' => [
                'key' => $config['key'],
                'secret' => $config['secret'],
            ],
        ]);

        $awsClient = new IOServiceForAwsS3($config);

        $this->assertEquals($expectedClient, $awsClient->GetClient());
    }

    public function testGetClientWithInvalidAuthTypeShouldThrowException()
    {
        $config['type'] = 'aws-s3';
        $config['auth-type'] = 'test';
        $config['bucket'] = '';
        $config['version'] = 'latest';
        $config['region'] = '';

        $awsClient = new IOServiceForAwsS3($config);
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Invalid auth type configuration");
        $awsClient->GetClient();
    }
}
class MockIOServiceForS3 extends IOServiceForAwsS3
{
    private $s3Client;

    function __construct($s3Client, $confg)
    {
        $this->s3Client = $s3Client;
        parent::__construct($confg);
    }

    public function GetClient()
    {
        return $this->s3Client;
    }
}
