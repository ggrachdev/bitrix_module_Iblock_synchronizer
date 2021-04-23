<?php

namespace GGrach\IblockSynchronizer\Synchronizer;

use \GGrach\IblockSynchronizer\SyncResult;
use \GGrach\IblockSynchronizer\Exceptions\SearchIblockException;
use \GGrach\IblockSynchronizer\Exceptions\BitrixRedactionException;
use \GGrach\IblockSynchronizer\Contracts\ISynchronizer;
use \Bitrix\Main\Loader;
use \Bitrix\Iblock\Iblock;

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

        if (Loader::includeModule('iblock')) {

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

    public function getArraySelectTo(array $arSyncRules): array {
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

    public function getArrayFilterTo(array $arSyncRules): array {
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

    public function getArraySelectFrom(array $arSyncRules): array {
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

    public function getArrayFilterFrom(array $arSyncRules): array {
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
            dre($arSyncRules, '+-a');

            $entityIblockFrom = Iblock::wakeUp($this->getFromIblockId())->getEntityDataClass();
            $entityIblockTo = Iblock::wakeUp($this->getToIblockId())->getEntityDataClass();

            if ($entityIblockFrom && $entityIblockTo) {

                // 1)
                $arSelectFrom = $this->getArraySelectFrom($arSyncRules);
                $arFilterFrom = $this->getArrayFilterFrom($arSyncRules);

                if (!empty($arSelectFrom) && !empty($arFilterFrom)) {

                    dre($arFilterFrom);

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
                                $newKeyFilterTo = $keyFilterTo;
                                foreach ($arSyncRules['CONFORMITY'] as $fromKey => $toKey) {
                                    $newKeyFilterTo = \str_replace($fromKey, $toKey, $newKeyFilterTo);
                                }

                                $arNewFilterTo[$newKeyFilterTo] = $valueFilterTo;
                            }

                            $arFilterTo = $arNewFilterTo;
                        }

                        if (!empty($arSyncRules['CONFORMITY']) && !empty($arSelectTo)) {
                            $arNewSelectTo = [];

                            foreach ($arSelectTo as $keySelectTo => $valueSelectTo) {
                                $newKeySelectTo = $keySelectTo;
                                $newValueSelectTo = $valueSelectTo;
                                foreach ($arSyncRules['CONFORMITY'] as $fromKey => $toKey) {
                                    $newValueSelectTo = \str_replace($fromKey, $toKey, $newValueSelectTo);
                                    $newKeySelectTo = \str_replace($fromKey, $toKey, $newKeySelectTo);
                                }

                                $arNewSelectTo[$newKeySelectTo] = $newValueSelectTo;
                            }

                            $arSelectTo = $arNewSelectTo;
                        }

                        $elementsTo = $entityIblockTo::getList([
                                'select' => $arSelectTo,
                                'filter' => $arFilterTo
                            ])->fetchAll();
                        
                        
                        $arSimilar = [];

                        if(!empty($elementsTo)) {
                            
                        }
                    }
                }
            }
        }

        return $syncResult;
    }

}
