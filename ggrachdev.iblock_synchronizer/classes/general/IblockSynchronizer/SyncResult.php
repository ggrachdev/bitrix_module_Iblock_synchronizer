<?php

namespace GGrach\IblockSynchronizer;

class SyncResult {

    /**
     * Массив идентификаторов синхронизированных элементов
     * @var array
     */
    private $arSynchronizedIds = [];

    /**
     * Массив идентификаторов не синхронизированных элементов
     * @var array
     */
    private $arNotSynchronizedIds = [];

    /**
     * Данные синхронизации
     * @var array
     */
    private $arSynchronizedData = [];

    /**
     * Массив идентификаторов похожих элементов
     * @var array
     */
    private $arSimilarIds = [];

    public function addSynchronizedId(int $id) {
        $this->arSynchronizedIds[] = $id;
    }

    public function setSynchronizedData(array $data) {
        $this->arSynchronizedData = $data;
    }

    public function getSynchronizedData(): array {
        return $this->arSynchronizedData;
    }

    public function addNotSynchronizedId(int $id) {
        $this->arNotSynchronizedIds[] = $id;
    }

    public function addSimilarId(int $id) {
        $this->arSimilarIds[] = $id;
    }

    public function getSynchronizedIds(): array {
        return $this->arSynchronizedIds;
    }

    public function getNotSynchronizedIds(): array {
        return $this->arNotSynchronizedIds;
    }

    public function getSimilarIds(): array {
        return $this->arSimilarIds;
    }

    public function isSuccess(): bool {
        return !empty($this->getSynchronizedIds()) && 
        !empty($this->getSimilarIds()) && 
        sizeof($this->getSynchronizedIds()) === sizeof($this->getSimilarIds());
    }

    public function isFail(): bool {
        return !$this->isSuccess();
    }

}
