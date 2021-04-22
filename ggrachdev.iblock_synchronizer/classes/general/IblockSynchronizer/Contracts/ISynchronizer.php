<?php

namespace GGrach\IblockSynchronizer\Contracts;

use GGrach\IblockSynchronizer\SyncResult;

interface ISynchronizer {
    public function __construct(int $fromIblockId, int $toIblockId);
    
    public function searchSimilarIds(array $params = []): array;
    
    public function sync(SyncResult $syncResult, array $arSyncRules): SyncResult;
}
