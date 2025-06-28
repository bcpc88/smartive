<?php

namespace BartlomiejCwiertniaRekrutacjaSmartiveapp\Adapter;

use BartlomiejCwiertniaRekrutacjaSmartiveapp\Port\FilesystemWriterInterface;
use Exception;

class LocalWriter implements FilesystemWriterInterface
{
    public const TYPE = 'local';

    public function write(string $path, string $contents): void
    {
        try {
            file_put_contents($path, $contents);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function supports(string $type): bool
    {
        return self::TYPE === $type;
    }
}
