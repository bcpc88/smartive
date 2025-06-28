<?php

namespace BartlomiejCwiertniaRekrutacjaSmartiveapp\Core\Handler;

use BartlomiejCwiertniaRekrutacjaSmartiveapp\Core\Message\GenerateThumbsMessage;
use BartlomiejCwiertniaRekrutacjaSmartiveapp\Core\Service\Resolver\ImageWriterResolver;
use BartlomiejCwiertniaRekrutacjaSmartiveapp\Port\FilesystemReaderInterface;
use BartlomiejCwiertniaRekrutacjaSmartiveapp\Port\ImageResizerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class GenerateThumbsHandler
{
    public function __construct(
        private FilesystemReaderInterface $reader,
        private ImageResizerInterface $resizer,
        private ImageWriterResolver $imageWriterResolver,
    ) {}

    public function __invoke(GenerateThumbsMessage $message): void
    {
        $sourceImage = $this->reader->read($message->sourcePath);
        $thumbImage = $this->resizer->resize($sourceImage, $message->width, $message->height);
        $this->imageWriterResolver->resolve($message->type)->write($message->targetPath, $thumbImage);
    }
}
