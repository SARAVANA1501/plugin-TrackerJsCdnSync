<?php


namespace Piwik\Plugins\TrackerJsCdnSync\BunnyCdn;


use Piwik\Plugins\TrackerJsCdnSync\IOService;

class IOServiceForBunnyCdn implements IOService
{
    private $config;
    private $helper;

    function __construct($config)
    {
        $this->config = $config;
        $this->helper = new BunnyCdnHelper($this->config['storageZoneName'],
            $this->config['apiAccessKey'], $this->config['storageZoneRegion']);
    }

    public function AddFile($file)
    {
        $baseName = basename($file);
        try {
            $this->helper->uploadFile($file, "/" . $this->config['storageZoneName'] . "/" . $baseName);
        } catch (BunnyCDNStorageAuthenticationException $e) {
        } catch (BunnyCDNStorageFileNotFoundException $e) {
        } catch (BunnyCDNStorageException $e) {
        }
    }

    public function DeleteFile($file)
    {
        $baseName = basename($file);
        try {
            $this->helper->deleteObject("/" . $this->config['storageZoneName'] . "/" . $baseName);
        } catch (BunnyCDNStorageAuthenticationException $e) {
        } catch (BunnyCDNStorageFileNotFoundException $e) {
        } catch (BunnyCDNStorageException $e) {
        }
    }
}