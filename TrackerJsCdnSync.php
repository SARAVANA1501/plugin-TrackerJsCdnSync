<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\TrackerJsCdnSync;

use Piwik\Config;
use Piwik\Plugins\TrackerJsCdnSync\GenerateEmbedCode\TagManagerEmbedCodeGenerator;

class TrackerJsCdnSync extends \Piwik\Plugin
{
    public function registerEvents()
    {
        return array(
            'TagManager.containerFileChanged' => array('function' => 'onStaticFileUpdate', 'after' => true),
            'TagManager.containerFileDeleted' => array('function' => 'onStaticFileDelete', 'after' => true),
            'API.TagManager.getContainerEmbedCode.end' => 'onGetTagManagerCode',
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
        $config = $this->getConfig();
        $ioServiceProvider = new IOServiceProvider($config);
        return $ioServiceProvider->GetIOService();
    }

    private function getConfig()
    {
        return Config::getInstance()->TrackerJsCdnSync;
    }

    public function onGetTagManagerCode(&$returnedValue, $extraInfo)
    {
        $config = $this->getConfig();
        $tagManagerEmbedCodeGenerator = new TagManagerEmbedCodeGenerator($config);
        $piwikBase = $this->getBaseUrl();
        $containerJs = $piwikBase . '/' . trim(\Piwik\Container\StaticContainer::get('TagManagerContainerWebDir'), '/') .'/';
        $tagManagerEmbedCodeGenerator->UpdateEmbedCode($containerJs, $returnedValue);
    }

    private function getBaseUrl()
    {
        $piwikBase = str_replace(array('http://', 'https://'), '', \Piwik\SettingsPiwik::getPiwikUrl());
        return rtrim($piwikBase, '/');
    }
}
