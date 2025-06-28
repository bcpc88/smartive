<?php

namespace BartlomiejCwiertniaRekrutacjaSmartiveapp\Core\Message;

final class GenerateThumbsMessage
{
    public function __construct(
        public readonly string $sourcePath,
        public readonly string $targetPath,
        public readonly ?int $width,
        public readonly ?int $height,
        public readonly string $type,
    ) {}
}

