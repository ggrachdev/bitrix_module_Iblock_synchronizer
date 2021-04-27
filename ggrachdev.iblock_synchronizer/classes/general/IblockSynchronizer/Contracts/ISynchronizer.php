<?php

namespace GGrach\IblockSynchronizer\Contracts;

use GGrach\IblockSynchronizer\SyncResult;

interface ISynchronizer {
    public function __construct(int $fromIblockId, int $toIblockId);
    
    public function run(): SyncResult;
    
    public function getFromIblockId(): int;

    public function getToIblockId(): int;

    public function setSyncResult(SyncResult $syncResult): void;
    
    public function getSyncResult(): SyncResult;

    public function setSyncRules(array $arSyncRules): void;
    
    public function getSyncRules(): array;
}
