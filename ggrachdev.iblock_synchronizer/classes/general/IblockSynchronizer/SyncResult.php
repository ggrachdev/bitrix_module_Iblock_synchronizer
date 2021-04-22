<?php

namespace GGrach\IblockSynchronizer;

class SyncResult {

    /**
     * Массив идентификаторов синхронизированных элементов
     * @var array
     */
    private array $arSynchronizedIds = [];

    /**
     * Массив идентификаторов не синхронизированных элементов
     * @var array
     */
    private array $arNotSynchronizedIds = [];

    /**
     * Массив идентификаторов похожих элементов
     * @var array
     */
    private array $arSimilarIds = [];

    public function addSynchronizedId(int $id): array {
        $this->arSyncronizedIds[] = $id;
    }

    public function addNotSynchronizedId(int $id): array {
        $this->arNotSynchronizedIds[] = $id;
    }

    public function addSimilarId(int $id): array {
        $this->arSimilarIds[] = $id;
    }

    public function getSyncronizedIds(): array {
        return $this->arSynchronizedIds;
    }

    public function getNotSyncronizedIds(): array {
        return $this->arNotSynchronizedIds;
    }

    public function getSimilarIds(): array {
        return $this->arSimilarIds;
    }

}
