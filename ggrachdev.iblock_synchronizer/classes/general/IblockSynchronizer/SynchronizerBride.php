<?php

namespace GGrach\IblockSynchronizer;

use GGrach\IblockSynchronizer\Exceptions\SearchIblockException;
use GGrach\IblockSynchronizer\Exceptions\BitrixRedactionException;
use GGrach\IblockSynchronizer\Parser\SyncRulesParser;
use \Bitrix\Main\Loader;

final class SynchronizerBride {

    private int $fromIblockId;
    private int $toIblockId;
    
    /**
     * Правила синхронизации
     * @var array
     */
    private array $arSyncRules = [];

    /**
     * @param int $fromIblockId - Откуда брать данные
     * @param int $toIblockId - Куда синхронизировать данные
     */
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

    public function getArSyncRules(): array {
        return $this->arSyncRules;
    }
    
    public function setSyncRules(array $arSyncRules)
    {
        $this->arSyncRules = SyncRulesParser::parse($arSyncRules);
    }
    
    public function sync(ISynchronizer $synchronizer): SyncResult
    {
        $resultSync = new SyncResult();
        return $synchronizer->sync($this->getFromIblockId(), $this->getToIblockId(), $resultSync, $this->getArSyncRules());
    }

}
