<?
\Bitrix\Main\Loader::registerAutoLoadClasses('ggrachdev.iblock_synchronizer', [
    "\GGrach\IblockSynchronizer\SynchronizerBridge" => "classes/general/IblockSynchronizer/SynchronizerBridge.php",
    
    // parser
    "\GGrach\IblockSynchronizer\Parser" => "classes/general/IblockSynchronizer/Parser/SyncRulesParser.php",
    
    // exceptions
    "\GGrach\IblockSynchronizer\Exceptions\BitrixRedactionException" => "classes/general/IblockSynchronizer/Exceptions/BitrixRedactionException.php",
    "\GGrach\IblockSynchronizer\Exceptions\SearchIblockException" => "classes/general/IblockSynchronizer/Exceptions/SearchIblockException.php",
    
    // contracts
    "\GGrach\IblockSynchronizer\Contracts" => "classes/general/IblockSynchronizer/Contracts/ISynchronizer.php",
    
    // synchronizer
    "\GGrach\IblockSynchronizer\Synchronizer\Synchronizer" => "classes/general/IblockSynchronizer/Synchronizer/Synchronizer.php",
    
    // other
    "\GGrach\IblockSynchronizer\SyncResult" => "classes/general/IblockSynchronizer/SyncResult.php"
]);
?>