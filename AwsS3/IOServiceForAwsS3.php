<?php


namespace Piwik\Plugins\TrackerJsCdnSync\AwsS3;


use Aws\S3\S3Client;
use Piwik\Plugins\TrackerJsCdnSync\IOService;

class IOServiceForAwsS3 implements IOService
{
    private $config;
    private $path;

    function __construct($config)
    {
        $this->config = $config;
        $this->path = '';
        if (isset($this->config['folder-prefix'])) {
            $this->path = $this->config['folder-prefix'] . '/';
        }
    }

    public function AddFile($file)
    {
        return $this->GetClient()->putObject([
            'Bucket' => $this->config['bucket'],
            'Key' => $this->path . basename($file),
            'SourceFile' => $file
        ]);
    }

    public function GetClient()
    {
        switch ($this->config['auth-type']) {
            case 'IAM-Role':
                return new S3Client([
                    'region' => $this->config['region'],
                    'version' => $this->config['version']
                ]);
                break;
            case 'IAM-User':
                return new S3Client([
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
        $this->GetClient()->deleteObject([
            'Bucket' => $this->config['bucket'],
            'Key' => $this->path . basename($file),
        ]);
    }
}