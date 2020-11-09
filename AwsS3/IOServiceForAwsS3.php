<?php


namespace Piwik\Plugins\TrackerJsCdnSync\AwsS3;


use Aws\S3\S3Client;
use Piwik\Plugins\TrackerJsCdnSync\IOService;

class IOServiceForAwsS3 implements IOService
{
    private $config;

    function __construct($config)
    {
        $this->config = $config;
    }

    public function AddFile($file)
    {
        if (isset($this->config['folder-path'])) {
            return $this->GetClient()->putObject([
                'Bucket' => $this->config['bucket'],
                'Key' => $this->config['folder-path'] . '/' . basename($file),
                'SourceFile' => $file
            ]);
        }
        return $this->GetClient()->putObject([
            'Bucket' => $this->config['bucket'],
            'Key' => basename($file),
            'SourceFile' => $file
        ]);
    }

    public function GetClient()
    {
        switch ($this->config['auth-type']) {
            case 'IAM-Role':
                return S3Client::factory([
                    'region' => $this->config['region'],
                    'version' => $this->config['version']
                ]);
                break;
            case 'IAM-User':
                return S3Client::factory([
                    'region' => $this->config['region'],
                    'version' => $this->config['version'],
                    'credentials' => [
                        'key' => $this->config['key'],
                        'secret' => $this->config['secret'],
                    ],
                ]);
                break;
            default:
                throw new \Exception('Invalid auth type configuration');

        }

    }

    public function DeleteFile($file)
    {
        if (isset($this->config['folder-path'])) {
            $this->GetClient()->deleteObject([
                'Bucket' => $this->config['bucket'],
                'Key' => $this->config['folder-path'] . '/' . basename($file),
            ]);
        } else {
            $this->GetClient()->deleteObject([
                'Bucket' => $this->config['bucket'],
                'Key' => basename($file)
            ]);
        }
    }
}