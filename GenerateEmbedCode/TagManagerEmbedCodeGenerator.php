<?php


namespace Piwik\Plugins\TrackerJsCdnSync\GenerateEmbedCode;


class TagManagerEmbedCodeGenerator
{
    private $config;
    public function __construct($config)
    {
        $this->config = $config;
    }

    public function UpdateEmbedCode($containerJs, $returnedValue)
    {
        if(empty($this->getCdnUrl()))
            return;

        if (is_string($returnedValue))
        {
            $returnedValue = str_replace($containerJs, self::getCdnUrl() . '/', $returnedValue);
        }
        elseif (is_array($returnedValue))
        {
            foreach ($returnedValue as $val) {
                if (!empty($val['embedCode'])) {
                    $val['embedCode'] = str_replace($containerJs, self::getCdnUrl() . '/', $val['embedCode']);
                }
            }
        }
        $returnedValue = str_replace($containerJs, self::getCdnUrl() . '/', $returnedValue);
    }

    private function getCdnUrl()
    {
        if(!array_key_exists('cdnUrl', $this->config))
            return '';

        return $this->config['cdnUrl'];
    }
}