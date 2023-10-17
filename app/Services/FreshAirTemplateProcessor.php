<?php

namespace App\Services;

use PhpOffice\PhpWord\TemplateProcessor;

class FreshAirTemplateProcessor extends TemplateProcessor
{
    public function cloneTableBlock($blockName, $clones = 1, $replace = true, $indexVariables = false, $variableReplacements = null)
    {
        $xmlBlock = null;
        $matches = [];
        $escapedMacroOpeningChars = self::$macroOpeningChars;
        $escapedMacroClosingChars = self::$macroClosingChars;

        preg_match(
            '/^(.*?)(\\' . $escapedMacroOpeningChars . $blockName . $escapedMacroClosingChars . ')(.*?)(\\' . $escapedMacroOpeningChars . '\/' . $blockName . $escapedMacroClosingChars . ')(.*)$/is',
            $this->tempDocumentMainPart,
            $matches
        );

        if (isset($matches[3])) {
            $xmlBlock = $matches[3];
            if ($indexVariables) {
                $cloned = $this->indexClonedVariables($clones, $xmlBlock);
            } elseif (is_array($variableReplacements)) {
                $cloned = $this->replaceClonedVariables($variableReplacements, $xmlBlock);
            } else {
                $cloned = [];
                for ($i = 1; $i <= $clones; ++$i) {
                    $cloned[] = $xmlBlock;
                }
            }

            if ($replace) {
                $this->tempDocumentMainPart = str_replace(
                    $matches[2] . $matches[3] . $matches[4],
                    implode('', $cloned),
                    $this->tempDocumentMainPart
                );
            }
        }

        return $xmlBlock;
    }
}
