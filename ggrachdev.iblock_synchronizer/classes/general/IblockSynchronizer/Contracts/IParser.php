<?php

namespace GGrach\IblockSynchronizer\Contracts;

interface IParser {
    public function parse(): array;
    
    public function isOtherProperty(string $codeProperty): bool;
    
    public function isSystemProperty(string $codeProperty): bool;
    
    public function isUserProperty(string $codeProperty): bool;
}
