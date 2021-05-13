<?php

namespace GGrach\IblockSynchronizer;

use \GGrach\IblockSynchronizer\Parser\SyncRulesParser;
use \GGrach\IblockSynchronizer\Contracts\ISynchronizer;
use \GGrach\IblockSynchronizer\Contracts\IParser;

final class SynchronizerBridge {

    private $synchronizer;
    private $parser;

    /**
     * Правила синхронизации
     * @var array
     */
    private $arSyncRules = [];

    public function __construct(IParser $parser, ISynchronizer $synchronizer) {
        $this->synchronizer = $synchronizer;
        $this->parser = $parser;
    }

    public function getSynchronizer(): ISynchronizer {
        return $this->synchronizer;
    }

    public function setSyncRules(array $arSyncRules): void {
        $this->arSyncRules = $this->parser->parse($arSyncRules);
    }

    public function sync(): SyncResult {
        $resultSync = new SyncResult();
        $this->getSynchronizer()->setParser($this->parser);
        $this->getSynchronizer()->setSyncRules($this->arSyncRules);
        $this->getSynchronizer()->setSyncResult($resultSync);
        return $this->getSynchronizer()->run();
    }

}
