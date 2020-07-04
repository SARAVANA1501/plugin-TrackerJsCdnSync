<?php

namespace Piwik\Plugins\TrackerJsCdnSync\tests\phpunit\GenerateEmbedCode;

use Piwik\Plugins\TrackerJsCdnSync\GenerateEmbedCode\TagManagerEmbedCodeGenerator;
use PHPUnit\Framework\TestCase;

class TagManagerEmbedCodeGeneratorTest extends TestCase
{

    public function testUpdateEmbedCodeWithArrayValue()
    {
        $config['cdnUrl'] = 'https://example.com/cdn';
        $containerJsUrl = 'https://matomo.com/js/';
        $embedCode = array(array('embedCode'=>'src = https://matomo.com/js/container_1.js'));
        $codeGenerator = new TagManagerEmbedCodeGenerator($config);

        $codeGenerator->UpdateEmbedCode($containerJsUrl, $embedCode);

        $this->assertEquals(array(array('embedCode'=>'src = https://example.com/cdn/container_1.js')), $embedCode);
    }

    public function testUpdateEmbedCodeWithStringValue()
    {
        $config['cdnUrl'] = 'https://example.com/cdn';
        $containerJsUrl = 'https://matomo.com/js/';
        $embedCode = 'src = https://matomo.com/js/container_1.js';
        $codeGenerator = new TagManagerEmbedCodeGenerator($config);

        $codeGenerator->UpdateEmbedCode($containerJsUrl, $embedCode);

        $this->assertEquals('src = https://example.com/cdn/container_1.js', $embedCode);
    }

    public function testUpdateEmbedCodeWithOutCdnUrl()
    {
        $config['test'] = 'value';
        $containerJsUrl = 'https://matomo.com/js/';
        $embedCode = 'src = https://matomo.com/js/container_1.js';
        $codeGenerator = new TagManagerEmbedCodeGenerator($config);

        $codeGenerator->UpdateEmbedCode($containerJsUrl, $embedCode);

        $this->assertEquals('src = https://matomo.com/js/container_1.js', $embedCode);
    }
}
