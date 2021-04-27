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
    private $fromIblockId;
    private $toIblockId;

    public function getFromIblockId() {
        return $this->fromIblockId;
    }

    public function getToIblockId() {
        return $this->toIblockId;
    }

    public function setFromIblockId($fromIblockId): void {
        $this->fromIblockId = $fromIblockId;
    }

    public function setToIblockId($toIblockId): void {
        $this->toIblockId = $toIblockId;
    }

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

    public function debug() {

        if (!empty($this->getSynchronizedData())) {
            foreach ($this->getSynchronizedData() as $idTo => $arDataFrom) {

                if (!empty($arDataFrom)) {
                    $arKeys = \array_keys($arDataFrom);

                    $idFrom = $arKeys[0];
                    echo '<pre>';
                    print_r('Синхронизируем в элемент ' . '<a target="_blank" href="/bitrix/admin/iblock_element_edit.php?IBLOCK_ID=' . $this->getToIblockId() . '&type=1c_catalog&lang=ru&ID=' . $idTo . '&find_section_section=0&WF=Y">' . $idTo . '</a>' . ' данные из ' . '<a target="_blank" href="/bitrix/admin/iblock_element_edit.php?IBLOCK_ID=' . $this->getFromIblockId() . '&type=1c_catalog&lang=ru&ID=' . $idFrom . '&find_section_section=0&WF=Y">' . $idFrom . '</a>');
                    echo '<pre>';
                }
            }
        }
    }

}
