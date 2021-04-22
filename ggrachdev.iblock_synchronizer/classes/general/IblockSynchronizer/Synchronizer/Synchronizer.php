<?php

namespace GGrach\IblockSynchronizer\Synchronizer;

use \GGrach\IblockSynchronizer\Contracts\ISynchronizer;
use \GGrach\IblockSynchronizer\SyncResult;

class Synchronizer implements ISynchronizer {
    
    public function __construct(int $fromIblockId, int $toIblockId, SyncResult $syncResult, array $arSyncRules) {
        
    }

    public function searchSimilarIds() {
        
    }

    public function sync(): SyncResult {
        
    }

}
