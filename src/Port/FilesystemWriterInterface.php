<?php

namespace BartlomiejCwiertniaRekrutacjaSmartiveapp\Port;

interface FilesystemWriterInterface
{
    public function write(string $path, string $contents): void;

    public function supports(string $type);
}
