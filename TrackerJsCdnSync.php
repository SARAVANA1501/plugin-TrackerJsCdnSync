<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\TrackerJsCdnSync;

use Piwik\Config;

class TrackerJsCdnSync extends \Piwik\Plugin
{
    public function registerEvents()
    {
        return array(
            'TagManager.containerFileChanged' => array('function' => 'onStaticFileUpdate', 'after' => true),
            'TagManager.containerFileDeleted' => array('function' => 'onStaticFileDelete', 'after' => true)
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

}
