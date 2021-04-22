<?php

if (\Bitrix\Main\Loader::includeModule('ggrachdev.iblock_synchronizer')) {
    $synchronizer = new \GGrach\IblockSynchronizer\SynchronizerBride(23, 4);
    $synchronizer->setSyncRules([
        // Задаем похожие свойства по которым искать соответствия
        'SIMILAR_PROPERTIES' => [
            'XML_ID', 'PROPERTY_CML2_ARTICLE'
        ],
        'SYNC_PROPERTIES' => [
            'PRICE'
        ]
    ]);
    
    $syncStatistic = $synchronizer->sync();
    
    echo '<pre>';
    print_r($syncStatistic);
    echo '</pre>';
}