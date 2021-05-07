<?php

namespace GGrach\IblockSynchronizer;

use GGrach\IblockSynchronizer\Parser\SyncRulesParser;
use GGrach\IblockSynchronizer\Contracts\ISynchronizer;

final class SynchronizerBridge {

    private $synchronizer;
    private $parserClass;

    /**
     * Правила синхронизации
     * @var array
     */
    private $arSyncRules = [];

    public function __construct($parserClass, ISynchronizer $synchronizer) {
        $this->synchronizer = $synchronizer;

        if (\class_exists($parserClass) && \method_exists($parserClass, 'parse')) {
            $this->parserClass = $parserClass;
        }
    }

    public function getSynchronizer(): ISynchronizer {
        return $this->synchronizer;
    }

    public function getArSyncRules(): array {
        return $this->arSyncRules;
    }

    public function setSyncRules(array $arSyncRules) {
        $this->arSyncRules = $this->parserClass::parse($arSyncRules);
    }

    public function sync(): SyncResult {
        $resultSync = new SyncResult();
        $this->getSynchronizer()->setSyncRules($this->getArSyncRules());
        $this->getSynchronizer()->setSyncResult($resultSync);
        return $this->getSynchronizer()->run();
    }

}
