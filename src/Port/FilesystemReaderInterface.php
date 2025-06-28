<?php

namespace BartlomiejCwiertniaRekrutacjaSmartiveapp\Port;

interface FilesystemReaderInterface
{
    public function read(string $path): string;
}
