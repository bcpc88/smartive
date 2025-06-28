<?php

namespace BartlomiejCwiertniaRekrutacjaSmartiveapp\Adapter;

use BartlomiejCwiertniaRekrutacjaSmartiveapp\Port\ImageResizerInterface;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;


class ImageResizer implements ImageResizerInterface
{
    private ImageManager $manager;

    public function __construct()
    {
        $this->manager = new ImageManager(new Driver());
    }

    public function resize(string $imageContent, int $width, ?int $height): string
    {
        return $this->manager->read($imageContent)
            ->scale($width, $height)
            ->toJpeg()
            ->toString();
    }
}
