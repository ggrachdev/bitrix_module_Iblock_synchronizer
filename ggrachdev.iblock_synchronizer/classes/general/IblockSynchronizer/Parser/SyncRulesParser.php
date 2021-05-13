<?php

namespace GGrach\IblockSynchronizer\Parser;

use \GGrach\IblockSynchronizer\Contracts\IParser;

class SyncRulesParser implements IParser {

    /**
     * Свойства которые считаются за системные свойства битрикса
     */
    const SYSTEM_PROPERTIES = [
        'NAME', 'ACTIVE', 'CODE', 'IBLOCK_SECTION_ID', 'DETAIL_TEXT', 'PREVIEW_TEXT', 'SORT', 'XML_ID'
    ];

    /**
     * Прочие свойства, которые не системные и не пользовательские и при этом валидные
     */
    const VALID_OTHER_PROPERTIES = [
        'PRICE'
    ];

    public function parse(array $arInputRules): array {
        $arValidRules = [
            'ERRORS' => 0,
            'ERRORS_TEXT' => [],
            'SIMILAR_PROPERTIES' => [
                'SYSTEM_PROPERTIES' => [],
                'USER_PROPERTIES' => [],
                'OTHER_PROPERTIES' => []
            ],
            'SYNC_PROPERTIES' => [
                'SYSTEM_PROPERTIES' => [],
                'USER_PROPERTIES' => [],
                'OTHER_PROPERTIES' => []
            ],
            'NOT_VALID_PROPERTIES' => [
                'SYNC_PROPERTIES' => [],
                'SIMILAR_PROPERTIES' => []
            ],
            'CONFORMITY' => []
        ];

        // Без похожих свойств нет смысла начинать проверку
        if (
            \array_key_exists('SIMILAR_PROPERTIES', $arInputRules) &&
            !empty($arInputRules['SYNC_PROPERTIES'])
        ) {

            foreach ($arInputRules['SIMILAR_PROPERTIES'] as $codeProperty) {

                $codeProperty = trim($codeProperty);

                if ($this->isUserProperty($codeProperty)) {
                    $arValidRules['SIMILAR_PROPERTIES']['USER_PROPERTIES'][] = \preg_replace('/^PROPERTY_/', '', $codeProperty);
                } else if ($this->isSystemProperty($codeProperty)) {
                    $arValidRules['SIMILAR_PROPERTIES']['SYSTEM_PROPERTIES'][] = $codeProperty;
                } else if ($this->isOtherProperty($codeProperty)) {
                    $arValidRules['SIMILAR_PROPERTIES']['OTHER_PROPERTIES'][] = $codeProperty;
                } else {
                    $arValidRules['ERRORS']++;
                    $arValidRules['NOT_VALID_PROPERTIES']['SIMILAR_PROPERTIES'][] = $codeProperty;
                    $arValidRules['ERRORS_TEXT'][] = 'Not valid SIMILAR_PROPERTIES with code = ' . $codeProperty;
                }
            }

            if (\array_key_exists('SYNC_PROPERTIES', $arInputRules) && !empty($arInputRules['SYNC_PROPERTIES'])) {

                foreach ($arInputRules['SYNC_PROPERTIES'] as $codeProperty) {

                    $codeProperty = trim($codeProperty);

                    if ($this->isUserProperty($codeProperty)) {
                        $arValidRules['SYNC_PROPERTIES']['USER_PROPERTIES'][] = \preg_replace('/^PROPERTY_/', '', $codeProperty);
                    } else if ($this->isSystemProperty($codeProperty)) {
                        $arValidRules['SYNC_PROPERTIES']['SYSTEM_PROPERTIES'][] = $codeProperty;
                    } else if ($this->isOtherProperty($codeProperty)) {
                        $arValidRules['SYNC_PROPERTIES']['OTHER_PROPERTIES'][] = $codeProperty;
                    } else {
                        $arValidRules['ERRORS']++;
                        $arValidRules['NOT_VALID_PROPERTIES']['SYNC_PROPERTIES'][] = $codeProperty;
                        $arValidRules['ERRORS_TEXT'][] = 'Not valid SYNC_PROPERTIES with code = ' . $codeProperty;
                    }
                }
            }

            // Свойства соответствия
            if (\array_key_exists('CONFORMITY', $arInputRules) && !empty($arInputRules['CONFORMITY'])) {

                foreach ($arInputRules['CONFORMITY'] as $codeFrom => $codeTo) {
                    if ($this->isUserProperty($codeFrom) && $this->isUserProperty($codeTo)) {
                        $arValidRules['CONFORMITY'] = [
                            \preg_replace('/^PROPERTY_/', '', $codeFrom) => \preg_replace('/^PROPERTY_/', '', $codeTo)
                        ];
                    }
                }
            }
        } else {
            $arValidRules['ERRORS']++;
            $arValidRules['ERRORS_TEXT'][] = 'Empty or not exist SIMILAR_PROPERTIES';
        }

        return $arValidRules;
    }

    public function isUserProperty(string $codeProperty): bool {

        $isSystemProperty = $this->isSystemProperty($codeProperty);
        $isUserProperty = false;

        if (!$isSystemProperty && \preg_match('/^PROPERTY_/', $codeProperty)) {
            $isUserProperty = true;
        }

        return $isUserProperty;
    }

    public function isOtherProperty(string $codeProperty): bool {

        $isOtherProperty = false;

        if (\in_array($codeProperty, self::VALID_OTHER_PROPERTIES)) {
            $isOtherProperty = true;
        }

        return $isOtherProperty;
    }

    public function isSystemProperty(string $codeProperty): bool {

        $isSystemProperty = false;

        if (\in_array($codeProperty, self::SYSTEM_PROPERTIES)) {
            $isSystemProperty = true;
        }

        return $isSystemProperty;
    }

}
