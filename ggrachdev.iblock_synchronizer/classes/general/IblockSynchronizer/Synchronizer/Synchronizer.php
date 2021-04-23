<?php

namespace GGrach\IblockSynchronizer\Synchronizer;

use \GGrach\IblockSynchronizer\SyncResult;
use \GGrach\IblockSynchronizer\Exceptions\SearchIblockException;
use \GGrach\IblockSynchronizer\Exceptions\BitrixRedactionException;
use \GGrach\IblockSynchronizer\Contracts\ISynchronizer;
use \Bitrix\Main\Loader;
use \Bitrix\Iblock\Iblock;
use \GGrach\IblockSynchronizer\Cache\RuntimeCache;

class Synchronizer implements ISynchronizer {

    private $fromIblockId;
    private $toIblockId;

    public function __construct(int $fromIblockId, int $toIblockId) {
        if ($fromIblockId <= 0) {
            throw new SearchIblockException('Iblock id ' . $fromIblockId . ' can be above zero ');
        }

        if ($toIblockId <= 0) {
            throw new SearchIblockException('Iblock id ' . $toIblockId . ' can be above zero ');
        }

        if (Loader::includeModule('iblock') && Loader::includeModule('sale')) {

            $dbFromRes = \CIBlock::GetList([], ['ID' => $fromIblockId]);

            if (!$dbFromRes->GetNext()) {
                throw new SearchIblockException('Not found iblock with id ' . $fromIblockId);
            }

            $dbToRes = \CIBlock::GetList([], ['ID' => $toIblockId]);

            if (!$dbToRes->GetNext()) {
                throw new SearchIblockException('Not found iblock with id ' . $toIblockId);
            }

            $this->fromIblockId = $fromIblockId;
            $this->toIblockId = $toIblockId;
        } else {
            throw new BitrixRedactionException('Modules required for the library to work were not found');
        }
    }

    public function getFromIblockId(): int {
        return $this->fromIblockId;
    }

    public function getToIblockId(): int {
        return $this->toIblockId;
    }

    protected function getArraySelectTo(array $arSyncRules): array {
        $arSelect = [];

        // Добавляем системные свойства
        if (!empty($arSyncRules['SIMILAR_PROPERTIES']['SYSTEM_PROPERTIES'])) {
            $arSelect = \array_merge($arSelect, $arSyncRules['SIMILAR_PROPERTIES']['SYSTEM_PROPERTIES']);
        }

        if (!empty($arSyncRules['SYNC_PROPERTIES']['SYSTEM_PROPERTIES'])) {
            $arSelect = \array_merge($arSelect, $arSyncRules['SYNC_PROPERTIES']['SYSTEM_PROPERTIES']);
        }

        // Добавляем пользовательские свойства
        if (!empty($arSyncRules['SIMILAR_PROPERTIES']['USER_PROPERTIES'])) {
            foreach ($arSyncRules['SIMILAR_PROPERTIES']['USER_PROPERTIES'] as $code) {
                $arSelect[$code . '_'] = $code;
            }
        }
        if (!empty($arSyncRules['SYNC_PROPERTIES']['USER_PROPERTIES'])) {
            foreach ($arSyncRules['SYNC_PROPERTIES']['USER_PROPERTIES'] as $code) {
                $arSelect[$code . '_'] = $code;
            }
        }

        if (!empty($arSelect)) {
            $arSelect[] = 'ID';
            $arSelect = \array_unique($arSelect);
        }

        return $arSelect;
    }

    protected function getArrayFilterTo(array $arSyncRules): array {
        $arFilter = [];

        // Добавляем системные свойства
        if (!empty($arSyncRules['SIMILAR_PROPERTIES']['SYSTEM_PROPERTIES'])) {
            foreach ($arSyncRules['SIMILAR_PROPERTIES']['SYSTEM_PROPERTIES'] as $code) {
                $arFilter['!=' . $code] = false;
            }
        }

        if (!empty($arSyncRules['SYNC_PROPERTIES']['SYSTEM_PROPERTIES'])) {
            foreach ($arSyncRules['SYNC_PROPERTIES']['SYSTEM_PROPERTIES'] as $code) {
                $arFilter['!=' . $code] = false;
            }
        }

        // Добавляем пользовательские свойства
        if (!empty($arSyncRules['SIMILAR_PROPERTIES']['USER_PROPERTIES'])) {
            foreach ($arSyncRules['SIMILAR_PROPERTIES']['USER_PROPERTIES'] as $code) {
                $arFilter['!=' . $code . '.VALUE'] = false;
            }
        }
        if (!empty($arSyncRules['SYNC_PROPERTIES']['USER_PROPERTIES'])) {
            foreach ($arSyncRules['SYNC_PROPERTIES']['USER_PROPERTIES'] as $code) {
                $arFilter['!=' . $code . '.VALUE'] = false;
            }
        }

        return $arFilter;
    }

    protected function getArraySelectFrom(array $arSyncRules): array {
        $arSelect = [];

        // Добавляем системные свойства
        if (!empty($arSyncRules['SIMILAR_PROPERTIES']['SYSTEM_PROPERTIES'])) {
            $arSelect = \array_merge($arSelect, $arSyncRules['SIMILAR_PROPERTIES']['SYSTEM_PROPERTIES']);
        }

        if (!empty($arSyncRules['SYNC_PROPERTIES']['SYSTEM_PROPERTIES'])) {
            $arSelect = \array_merge($arSelect, $arSyncRules['SYNC_PROPERTIES']['SYSTEM_PROPERTIES']);
        }

        // Добавляем пользовательские свойства
        if (!empty($arSyncRules['SIMILAR_PROPERTIES']['USER_PROPERTIES'])) {
            foreach ($arSyncRules['SIMILAR_PROPERTIES']['USER_PROPERTIES'] as $code) {
                $arSelect[$code . '_'] = $code;
            }
        }
        if (!empty($arSyncRules['SYNC_PROPERTIES']['USER_PROPERTIES'])) {
            foreach ($arSyncRules['SYNC_PROPERTIES']['USER_PROPERTIES'] as $code) {
                $arSelect[$code . '_'] = $code;
            }
        }

        if (!empty($arSelect)) {
            $arSelect[] = 'ID';
            $arSelect = \array_unique($arSelect);
        }

        return $arSelect;
    }

    protected function getArrayFilterFrom(array $arSyncRules): array {
        $arFilter = [];

        // Добавляем системные свойства
        if (!empty($arSyncRules['SIMILAR_PROPERTIES']['SYSTEM_PROPERTIES'])) {
            foreach ($arSyncRules['SIMILAR_PROPERTIES']['SYSTEM_PROPERTIES'] as $code) {
                $arFilter['!=' . $code] = false;
            }
        }

        if (!empty($arSyncRules['SYNC_PROPERTIES']['SYSTEM_PROPERTIES'])) {
            foreach ($arSyncRules['SYNC_PROPERTIES']['SYSTEM_PROPERTIES'] as $code) {
                $arFilter['!=' . $code] = false;
            }
        }

        // Добавляем пользовательские свойства
        if (!empty($arSyncRules['SIMILAR_PROPERTIES']['USER_PROPERTIES'])) {
            foreach ($arSyncRules['SIMILAR_PROPERTIES']['USER_PROPERTIES'] as $code) {
                $arFilter['!=' . $code . '.VALUE'] = false;
            }
        }
        if (!empty($arSyncRules['SYNC_PROPERTIES']['USER_PROPERTIES'])) {
            foreach ($arSyncRules['SYNC_PROPERTIES']['USER_PROPERTIES'] as $code) {
                $arFilter['!=' . $code . '.VALUE'] = false;
            }
        }

        return $arFilter;
    }

    /**
     * На выходе получаем
     * key string - id массива to
     * value array - какие значения надо вставить (массив, потому что может быть найдено несколько соответствий)
     * 
     * @param array $elementsFrom
     * @param array $elementsTo
     * @param array $arSyncRules
     * @return array
     */
    protected function getSimilarArrayElements(array $elementsFrom, array $elementsTo, array $arSyncRules): array {

        $arSimilar = [];

        if (!empty($elementsFrom) && !empty($elementsTo) && !empty($arSyncRules)) {
            dre($arSyncRules['SIMILAR_PROPERTIES']);

            $systemSimilarProperties = !empty($arSyncRules['SIMILAR_PROPERTIES']['SYSTEM_PROPERTIES']) ? $arSyncRules['SIMILAR_PROPERTIES']['SYSTEM_PROPERTIES'] : null;
            $userSimilarProperties = !empty($arSyncRules['SIMILAR_PROPERTIES']['USER_PROPERTIES']) ? $arSyncRules['SIMILAR_PROPERTIES']['USER_PROPERTIES'] : null;

            $systemSyncProperties = !empty($arSyncRules['SYNC_PROPERTIES']['SYSTEM_PROPERTIES']) ? $arSyncRules['SYNC_PROPERTIES']['SYSTEM_PROPERTIES'] : null;
            $userSyncProperties = !empty($arSyncRules['SYNC_PROPERTIES']['USER_PROPERTIES']) ? $arSyncRules['SYNC_PROPERTIES']['USER_PROPERTIES'] : null;
            $otherSyncProperties = !empty($arSyncRules['SYNC_PROPERTIES']['OTHER_PROPERTIES']) ? $arSyncRules['SYNC_PROPERTIES']['OTHER_PROPERTIES'] : null;

            $arIdsSimilarFrom = [];

            foreach ($elementsTo as $elementTo) {
                foreach ($elementsFrom as $elementFrom) {
                    $isSimilar = true;

                    // Проверяем системные свойства
                    if ($systemSimilarProperties) {
                        foreach ($systemSimilarProperties as $codeSystemProperty) {
                            if (!empty($elementTo[$codeSystemProperty]) && !empty($elementFrom[$codeSystemProperty])) {
                                if ($elementTo[$codeSystemProperty] != $elementFrom[$codeSystemProperty]) {
                                    $isSimilar = false;
                                    break;
                                }
                            } else {
                                $isSimilar = false;
                                break;
                            }
                        }
                    }

                    // Проверяем пользовательские свойства
                    if ($userSimilarProperties && $isSimilar) {
                        foreach ($userSimilarProperties as $codeUserPropertyFrom) {
                            $codeUserPropertyTo = $this->getCodeTo($codeUserPropertyFrom, $arSyncRules);

                            if (
                                !empty($elementFrom[$codeUserPropertyFrom . '_VALUE']) &&
                                !empty($elementTo[$codeUserPropertyTo . '_VALUE'])
                            ) {
                                if ($elementFrom[$codeUserPropertyFrom . '_VALUE'] != $elementTo[$codeUserPropertyTo . '_VALUE']) {
                                    $isSimilar = false;
                                    break;
                                }
                            } else {
                                $isSimilar = false;
                                break;
                            }
                        }
                    }

                    if ($isSimilar) {
                        if (!isset($arSimilar[$elementTo['ID']])) {
                            $arSimilar[$elementTo['ID']] = [];
                        }

                        $arUpdate = [];

                        if ($systemSyncProperties) {
                            foreach ($systemSyncProperties as $codeSystemProperty) {
                                $arUpdate[$codeSystemProperty] = $elementFrom[$codeSystemProperty];
                            }
                        }

                        if ($userSyncProperties) {
                            foreach ($userSyncProperties as $codeUserPropertyFrom) {
                                $codeUserPropertyTo = $this->getCodeTo($codeUserPropertyFrom, $arSyncRules);

                                $arUpdate[$codeUserPropertyTo] = $elementFrom[$codeUserPropertyFrom . '_VALUE'];
                            }
                        }

                        if ($otherSyncProperties) {
                            if (\in_array('PRICE', $otherSyncProperties)) {
                                $arUpdate['PRICES'] = [];
                            }
                        }

                        $arIdsSimilarFrom[] = $elementFrom['ID'];
                        $arSimilar[$elementTo['ID']][$elementFrom['ID']] = $arUpdate;
                    }
                }
            }


            $arIdsSimilarFrom = \array_unique($arIdsSimilarFrom);

            if (\in_array('PRICE', $otherSyncProperties) && !empty($arIdsSimilarFrom)) {
                $prices = \Bitrix\Catalog\PriceTable::getList(
                        [
                            'filter' => [
                                '=PRODUCT_ID' => $arIdsSimilarFrom
                            ]
                        ]
                    )->fetchAll();
                
                $arAdaptedPrices = [];
                
                if(!empty($prices)) {
                    foreach ($prices as $arPrice) {
                        if(!isset($arAdaptedPrices[$arPrice['PRODUCT_ID']]))
                        {
                            $arAdaptedPrices[$arPrice['PRODUCT_ID']] = [];
                        }
                        
                        $arAdaptedPrices[$arPrice['PRODUCT_ID']][$arPrice['CATALOG_GROUP_ID']] = $arPrice;
                    }
                    
                    foreach($arSimilar as $idTo => &$arDataTo)
                    {
                        foreach($arDataTo as $idFrom => &$arDataFrom)
                        {
                            $arDataFrom['PRICES'] = \array_key_exists($idFrom, $arAdaptedPrices) ? $arAdaptedPrices[$idFrom] : [];
                        }
                    }
                    
                    dre($arSimilar, 'a+-');
                }
            }
        }

        return $arSimilar;
    }

    protected function getCodeTo(string $codeFrom, array $arSyncRules): string {
        if (!empty($arSyncRules['CONFORMITY'])) {
            $codePropertyTo = str_replace(array_keys($arSyncRules['CONFORMITY']), \array_values($arSyncRules['CONFORMITY']), $codeFrom);
        } else {
            $codePropertyTo = $codeFrom;
        }

        return $codePropertyTo;
    }

    /**
     * 1) Получаем все элементы инфоблока from
     * 2) Ищем соответствия в инфоблоке to
     * 3) Достаем данные для синхронизации из инфоблока from
     * 4) Синхронизируем из from в to
     * 
     * @param SyncResult $syncResult
     * @param array $arSyncRules
     * @return SyncResult
     */
    public function sync(SyncResult $syncResult, array $arSyncRules): SyncResult {

        if (!empty($arSyncRules) && $arSyncRules['ERRORS'] === 0) {

            $entityIblockFrom = Iblock::wakeUp($this->getFromIblockId())->getEntityDataClass();
            $entityIblockTo = Iblock::wakeUp($this->getToIblockId())->getEntityDataClass();

            if ($entityIblockFrom && $entityIblockTo) {

                // 1)
                $arSelectFrom = $this->getArraySelectFrom($arSyncRules);
                $arFilterFrom = $this->getArrayFilterFrom($arSyncRules);

                if (!empty($arSelectFrom) && !empty($arFilterFrom)) {

                    $elementsFrom = $entityIblockFrom::getList([
                            'select' => $arSelectFrom,
                            'filter' => $arFilterFrom
                        ])->fetchAll();

                    if (!empty($elementsFrom)) {

                        //2 
                        $arSelectTo = $this->getArraySelectTo($arSyncRules);
                        $arFilterTo = $this->getArrayFilterTo($arSyncRules);

                        foreach ($elementsFrom as $element) {

                            if (!empty($arSyncRules['SIMILAR_PROPERTIES']['USER_PROPERTIES'])) {
                                foreach ($arSyncRules['SIMILAR_PROPERTIES']['USER_PROPERTIES'] as $code) {
                                    if (!empty($element[$code . '_VALUE'])) {

                                        if (!isset($arFilterTo['=' . $code . '.VALUE'])) {
                                            $arFilterTo['=' . $code . '.VALUE'] = [];
                                        }

                                        $arFilterTo['=' . $code . '.VALUE'][] = $element[$code . '_VALUE'];
                                    }
                                }
                            }

                            if (!empty($arSyncRules['SIMILAR_PROPERTIES']['SYSTEM_PROPERTIES'])) {
                                foreach ($arSyncRules['SIMILAR_PROPERTIES']['SYSTEM_PROPERTIES'] as $code) {
                                    if (!empty($element[$code])) {

                                        if (!isset($arFilterTo['=' . $code])) {
                                            $arFilterTo['=' . $code] = [];
                                        }

                                        $arFilterTo['=' . $code][] = $element[$code];
                                    }
                                }
                            }
                        }

                        if (!empty($arSyncRules['CONFORMITY']) && !empty($arFilterTo)) {

                            $arNewFilterTo = [];

                            foreach ($arFilterTo as $keyFilterTo => $valueFilterTo) {
                                $newKeyFilterTo = $this->getCodeTo($keyFilterTo, $arSyncRules);

                                $arNewFilterTo[$newKeyFilterTo] = $valueFilterTo;
                            }

                            $arFilterTo = $arNewFilterTo;
                        }

                        if (!empty($arSyncRules['CONFORMITY']) && !empty($arSelectTo)) {
                            $arNewSelectTo = [];

                            foreach ($arSelectTo as $keySelectTo => $valueSelectTo) {
                                $newValueSelectTo = $this->getCodeTo($valueSelectTo, $arSyncRules);
                                $newKeySelectTo = $this->getCodeTo($keySelectTo, $arSyncRules);

                                $arNewSelectTo[$newKeySelectTo] = $newValueSelectTo;
                            }

                            $arSelectTo = $arNewSelectTo;
                        }

                        $elementsTo = $entityIblockTo::getList([
                                'select' => $arSelectTo,
                                'filter' => $arFilterTo
                            ])->fetchAll();

                        $arSimilar = $this->getSimilarArrayElements($elementsFrom, $elementsTo, $arSyncRules);
                    }
                }
            }
        }

        return $syncResult;
    }

}
