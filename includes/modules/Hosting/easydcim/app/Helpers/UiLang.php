<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Helpers;

/**
 * The strings shown by the WHMCS-style UI script (templates/assets/js/edcUi.js),
 * handed to the page as JSON. They live in the module's lang file under
 * "edcUi", next to everything else the module translates.
 */
class UiLang
{
    public static function json(): string
    {
        // HEX flags keep the output safe inside a <script> block.
        return (string) json_encode(self::strings(), JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
    }

    public static function strings(): array
    {
        $lang = [];
        include dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'lang' . DIRECTORY_SEPARATOR . 'english.php';

        return (array) ($lang['edcUi'] ?? []);
    }
}
