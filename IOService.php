<?php


namespace Piwik\Plugins\TrackerJsCdnSync;


interface IOService
{
    public function AddFile($file);
    public function DeleteFile($file);
}