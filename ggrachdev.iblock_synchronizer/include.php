<?
\Bitrix\Main\Loader::registerAutoLoadClasses('ggrachdev.iblock_synchronizer', [
    "\GGrach\IblockSynchronizer\SynchronizerBridge" => "classes/general/IblockSynchronizer/SynchronizerBridge.php",
    
    // parser
    "\GGrach\IblockSynchronizer\Parser\SyncRulesParser" => "classes/general/IblockSynchronizer/Parser/SyncRulesParser.php",
    
    // exceptions
    "\GGrach\IblockSynchronizer\Exceptions\BitrixRedactionException" => "classes/general/IblockSynchronizer/Exceptions/BitrixRedactionException.php",
    "\GGrach\IblockSynchronizer\Exceptions\SearchIblockException" => "classes/general/IblockSynchronizer/Exceptions/SearchIblockException.php",
    
    // contracts
    "\GGrach\IblockSynchronizer\Contracts\ISynchronizer" => "classes/general/IblockSynchronizer/Contracts/ISynchronizer.php",
    "\GGrach\IblockSynchronizer\Contracts\IParser" => "classes/general/IblockSynchronizer/Contracts/IParser.php",
    "\GGrach\IblockSynchronizer\Contracts\IComparator" => "classes/general/IblockSynchronizer/Contracts/IComparator.php",
    
    // synchronizer
    "\GGrach\IblockSynchronizer\Synchronizer\Synchronizer" => "classes/general/IblockSynchronizer/Synchronizer/Synchronizer.php",
    
    // comparators
    "\GGrach\IblockSynchronizer\Comparator\EqualComparator" => "classes/general/IblockSynchronizer/Comparator/EqualComparator.php",
    "\GGrach\IblockSynchronizer\Comparator\IdenticalComparator" => "classes/general/IblockSynchronizer/Comparator/IdenticalComparator.php",
    
    // other
    "\GGrach\IblockSynchronizer\SyncResult" => "classes/general/IblockSynchronizer/SyncResult.php",
    "\GGrach\IblockSynchronizer\Cache\RuntimeCache" => "classes/general/IblockSynchronizer/Cache/RuntimeCache.php"
]);
?>