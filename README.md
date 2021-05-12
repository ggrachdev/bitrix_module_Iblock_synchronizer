Модуль добавляет набор классов для синхронизации данных элементов, включая цены.

**У синхронизируемых инфоблоков обязательно должно быть заполнено свойство Символьный код API**

**В данный момент модуль может синхронизировать только цены, в будущем доработаю**

Модуль тестировался только при сравнивании текстовых и численных одиночных свойств

Протестировано на php 7.2.34 с синхронизацией 1700 товаров с около 10 типами цен

```php
<?

if (\Bitrix\Main\Loader::includeModule('ggrachdev.iblock_synchronizer')) {

   set_time_limit(0);

   // Синхронизируем данные элементов из инфоблока 23 в инфоблок 4, создав синхронизатор
   $synchronizer = new \GGrach\IblockSynchronizer\Synchronizer\Synchronizer(23, 4);

   $synchronizerWrapper = new \GGrach\IblockSynchronizer\SynchronizerBridge(
        GGrach\IblockSynchronizer\Parser\SyncRulesParser::class,
        $synchronizer
    );

   $synchronizerWrapper->setSyncRules([
       // Задаем похожие свойства по которым искать соответствия
       // Т.е ищутся элементы из IBLOCK_ID=4 в которых PROPERTY_CML2_ARTICLE такой же как в IBLOCK_ID=23
       // Можно задавать и системные свойства: NAME, XML_ID etc.
       'SIMILAR_PROPERTIES' => [
           'PROPERTY_CML2_ARTICLE'
       ],
       // Задаем свойства, которые нужно синхронизировать
       'SYNC_PROPERTIES' => [
           // Задаем правило, что надо синхронизировать цены
           'PRICE'
       ],
       // Соответствия свойств инфоблок from => инфоблок to
       'CONFORMITY' => [
           // Задаем правило, мол в IBLOCK_ID=4 свойство из IBLOCK_ID=23 имеет другой символьный код - PROPERTY_VENDOR_CODE
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

   // Выведет кликабельные ссылки откуда и куда происходила синхронизация
   $syncResult->debug();
   echo '</pre>';
}
?>
```