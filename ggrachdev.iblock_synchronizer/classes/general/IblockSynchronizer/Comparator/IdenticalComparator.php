<?php

namespace GGrach\IblockSynchronizer\Comparator;

use \GGrach\IblockSynchronizer\Contracts\IComparator;

class IdenticalComparator implements IComparator {

    public function isSimilar($entityFirst, $entitySecond): bool {

        $isSimilar = false;

        if (!empty($entityFirst) && !empty($entitySecond)) {
            if (trim($entityFirst) === trim($entitySecond)) {
                $isSimilar = true;
            }
        }

        return $isSimilar;
    }

}
