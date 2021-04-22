<?php

namespace GGrach\IblockSynchronizer\Contracts;

use GGrach\IblockSynchronizer\SyncResult;

interface ISynchronizer {
    public function __construct(int $fromIblockId, int $toIblockId, SyncResult $syncResult, array $arSyncRules);
    
    public function searchSimilarIds();
    
    public function sync(): SyncResult;
}
