<?php

namespace GGrach\IblockSynchronizer;

use GGrach\IblockSynchronizer\Parser\SyncRulesParser;

final class SynchronizerBridge {

    private ISynchronizer $synchronizer;

    /**
     * Правила синхронизации
     * @var array
     */
    private array $arSyncRules = [];

    public function __construct(ISynchronizer $synchronizer) {
        $this->synchronizer = $synchronizer;
    }

    public function getSynchronizer(): ISynchronizer {
        return $this->synchronizer;
    }

    public function getArSyncRules(): array {
        return $this->arSyncRules;
    }

    public function setSyncRules(array $arSyncRules) {
        $this->arSyncRules = SyncRulesParser::parse($arSyncRules);
    }

    public function sync(): SyncResult {
        $resultSync = new SyncResult();
        return $this->getSynchronizer()->sync($resultSync, $this->getArSyncRules());
    }

}
