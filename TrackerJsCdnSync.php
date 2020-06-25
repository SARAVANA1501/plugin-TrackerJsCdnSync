<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\TrackerJsCdnSync;

use Piwik\Config;
use Piwik\Plugins\LogViewer\Log\Parser\Piwik;

class TrackerJsCdnSync extends \Piwik\Plugin
{
    public function registerEvents()
    {
        return array(
            'TagManager.containerFileChanged' => array('function' => 'onStaticFileUpdate', 'after' => true),
            'TagManager.containerFileDeleted' => array('function' => 'onStaticFileDelete', 'after' => true),
            'TagManager.getContainerEmbedCode.end' => 'onGetTagManagerCode',
            'API.TagManager.getContainerInstallInstructions.end' => 'onGetTagManagerCode'
        );
    }

    public function onStaticFileUpdate($file)
    {
        $this->getIOService()->AddFile($file);
    }

    public function onStaticFileDelete($file)
    {
        $this->getIOService()->DeleteFile($file);
    }

    private function getIOService(): IOService
    {
        $config = Config::getInstance()->TrackerJsCdnSync;
        $ioServiceProvider = new IOServiceProvider($config);
        return $ioServiceProvider->GetIOService();
    }
    public function onGetTagManagerCode(&$returnedValue, $extraInfo)
    {
        $myfile = fopen("newfile.txt", "a") or die("Unable to open file!");
        fwrite($myfile, "test string");
        fwrite($myfile, $returnedValue);
        fwrite($myfile, $extraInfo);
        fclose($myfile);
    }

    private function getBaseUrl()
    {
        $piwikBase = str_replace(array('http://', 'https://'), '', \Piwik\SettingsPiwik::getPiwikUrl());
        return rtrim($piwikBase, '/');
    }

    private static function getCdnUrl($includeProtocol = false)
    {
        return 'https://mycdn.mydomain.com/mypath'; // path should be read from a config
    }

}
