<?php

namespace BartlomiejCwiertniaRekrutacjaSmartiveapp\Core\Service\Resolver;

use BartlomiejCwiertniaRekrutacjaSmartiveapp\Port\FilesystemWriterInterface;
use InvalidArgumentException;

final class ImageWriterResolver
{
    public function __construct(
        private iterable $writers
    ) {
    }

    public function resolve(string $type): FilesystemWriterInterface
    {
        /** @var FilesystemWriterInterface $writer */
        foreach ($this->writers as $writer) {
            if ($writer->supports($type)) {
                return $writer;
            }
        }

        throw new InvalidArgumentException("Unknown writer: $type");
    }
}
