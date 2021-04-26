<?php

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

if (\Bitrix\Main\Loader::includeModule('ggrachdev.iblock_synchronizer')) {

    // Синхронизируем данные элементов из инфоблока 23 в инфоблок 4, создав синхронизатор
    $synchronizer = new \GGrach\IblockSynchronizer\Synchronizer\Synchronizer(23, 4);

    $synchronizerWrapper = new \GGrach\IblockSynchronizer\SynchronizerBridge($synchronizer);

    $synchronizerWrapper->setSyncRules([
        // Задаем похожие свойства по которым искать соответствия
        'SIMILAR_PROPERTIES' => [
            'PROPERTY_CML2_ARTICLE'
        ],
        // Задаем свойства, которые нужно синхронизировать
        'SYNC_PROPERTIES' => [
            'PRICE'
        ],
        // Соответствия свойств инфоблок from => инфоблок to
        'CONFORMITY' => [
            'PROPERTY_CML2_ARTICLE' => 'PROPERTY_VENDOR_CODE'
        ]
    ]);

    // Получаем GGrach\IblockSynchronizer\SyncResult;
    $syncResult = $synchronizerWrapper->sync();

    echo '<pre>';
    print_r($syncResult->getSimilarIds());
    print_r($syncResult->getSynchronizedIds());
    print_r($syncResult->getNotSynchronizedIds());
    print_r($syncResult->getSynchronizedData());
    var_dump($syncResult->isSuccess());
    echo '</pre>';
}
