<?php

namespace GGrach\IblockSynchronizer\Synchronizer;

use \GGrach\IblockSynchronizer\Contracts\ISynchronizer;
use \GGrach\IblockSynchronizer\SyncResult;
use GGrach\IblockSynchronizer\Exceptions\SearchIblockException;
use GGrach\IblockSynchronizer\Exceptions\BitrixRedactionException;
use \Bitrix\Main\Loader;

class Synchronizer implements ISynchronizer {
    
    private int $fromIblockId;
    private int $toIblockId;
    
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

    public function searchSimilarIds() {
        
    }

    public function sync(SyncResult $syncResult, array $arSyncRules): SyncResult {
        
    }

}
