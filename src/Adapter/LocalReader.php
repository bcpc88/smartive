<?php

namespace BartlomiejCwiertniaRekrutacjaSmartiveapp\Adapter;

use BartlomiejCwiertniaRekrutacjaSmartiveapp\Port\FilesystemReaderInterface;
use RuntimeException;

class LocalReader implements FilesystemReaderInterface
{
    public function read(string $path): string
    {
        $image = file_get_contents($path);
        if (false === $image) {
            throw new RuntimeException('Could not read source image.');
        }

        return $image;
    }
}
