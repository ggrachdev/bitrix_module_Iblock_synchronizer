<?php

namespace GGrach\IblockSynchronizer\Contracts;

use GGrach\IblockSynchronizer\SyncResult;

interface ISynchronizer {
    public function __construct(int $fromIblockId, int $toIblockId);
    
    public function sync(SyncResult $syncResult, array $arSyncRules): SyncResult;
    
    public function getFromIblockId(): int;

    public function getToIblockId(): int;
}
