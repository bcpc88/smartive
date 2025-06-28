<?php

namespace BartlomiejCwiertniaRekrutacjaSmartiveapp\Port;

interface ImageResizerInterface
{
    public function resize(string $imageContent, int $width, int $height): string;
}
