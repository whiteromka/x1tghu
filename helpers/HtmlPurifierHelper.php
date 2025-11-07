<?php

namespace app\helpers;

use HTMLPurifier;
use HTMLPurifier_Config;

class HtmlPurifierHelper
{
    private $purifier;

    public function __construct()
    {
        $config = HTMLPurifier_Config::createDefault();
        $config->set('HTML.Allowed', 'b,i,s');
        $config->set('AutoFormat.RemoveEmpty', true);
        $config->set('AutoFormat.RemoveEmpty.RemoveNbsp', true);
        $this->purifier = new HTMLPurifier($config);
    }

    /**
     * Очищает HTML, оставляя только разрешенные теги
     */
    public function purify(string $html): string
    {
        if (empty(trim($html))) {
            return $html;
        }
        return $this->purifier->purify($html);
    }
}
