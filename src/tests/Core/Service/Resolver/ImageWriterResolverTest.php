<?php

namespace BartlomiejCwiertniaRekrutacjaSmartiveapp\Tests\Core\Service\Resolver;

use BartlomiejCwiertniaRekrutacjaSmartiveapp\Adapter\FtpWriter;
use BartlomiejCwiertniaRekrutacjaSmartiveapp\Adapter\LocalWriter;
use BartlomiejCwiertniaRekrutacjaSmartiveapp\Core\Service\Resolver\ImageWriterResolver;
use BartlomiejCwiertniaRekrutacjaSmartiveapp\Port\FilesystemWriterInterface;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class ImageWriterResolverTest extends TestCase
{
    public function testResolvesFTPWriterType(): void
    {
        $ftpWriter = $this->createMock(FtpWriter::class);
        $ftpWriter->method('supports')->with('ftp')->willReturn(true);

        $localWriter = $this->createMock(LocalWriter::class);
        $localWriter->method('supports')->with('ftp')->willReturn(false);

        $resolver = new ImageWriterResolver([$ftpWriter, $localWriter]);

        $this->assertSame($ftpWriter, $resolver->resolve('ftp'));
    }

    public function testResolvesLocalWriterType(): void
    {
        $ftpWriter = $this->createMock(FtpWriter::class);
        $ftpWriter->method('supports')->with('local')->willReturn(false);

        $localWriter = $this->createMock(LocalWriter::class);
        $localWriter->method('supports')->with('local')->willReturn(true);

        $resolver = new ImageWriterResolver([$ftpWriter, $localWriter]);

        $this->assertSame($localWriter, $resolver->resolve('local'));
    }

    public function testThrowsExceptionWhenNoWriterIsSupported(): void
    {
        $writer = $this->createMock(FilesystemWriterInterface::class);
        $writer->method('supports')->willReturn(false);

        $resolver = new ImageWriterResolver([$writer]);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Unknown writer: unknown');

        $resolver->resolve('unknown');
    }
}
