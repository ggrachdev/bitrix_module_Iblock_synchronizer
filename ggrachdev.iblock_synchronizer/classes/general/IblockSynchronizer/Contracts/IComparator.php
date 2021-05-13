<?php

namespace GGrach\IblockSynchronizer\Contracts;

interface IComparator {
    public function isSimilar($entityFirst, $entitySecond) : bool;
}
