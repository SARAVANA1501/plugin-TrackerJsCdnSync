<?php


namespace Piwik\Plugins\TrackerJsCdnSync\GenerateEmbedCode;


class TagManagerEmbedCodeGenerator
{
    private $config;
    public function __construct($config)
    {
        $this->config = $config;
    }

    public function UpdateEmbedCode($containerJsUrl, &$embedCode)
    {
        if(empty($this->getCdnUrl()))
            return;


        $cdnUrl = self::getCdnUrl();
        if (is_string($embedCode))
        {
            $embedCode = str_replace($containerJsUrl, $cdnUrl . '/', $embedCode);
            return;
        }
        elseif (is_array($embedCode))
        {
            foreach ($embedCode as &$val) {
                if (!empty($val['embedCode'])) {
                    $val['embedCode'] = str_replace($containerJsUrl, $cdnUrl . '/', $val['embedCode']);
                }
            }
            return;
        }
        $embedCode = str_replace($containerJsUrl, $cdnUrl . '/', $embedCode);
    }

    private function getCdnUrl()
    {
        if(!array_key_exists('cdnUrl', $this->config))
            return '';

        return $this->config['cdnUrl'];
    }
}