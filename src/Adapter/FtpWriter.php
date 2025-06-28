<?php

namespace BartlomiejCwiertniaRekrutacjaSmartiveapp\Adapter;

use BartlomiejCwiertniaRekrutacjaSmartiveapp\Port\FilesystemWriterInterface;
use Exception;
use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemException;
use League\Flysystem\Ftp\FtpAdapter;
use League\Flysystem\Ftp\FtpConnectionOptions;
use RuntimeException;

class FtpWriter implements FilesystemWriterInterface
{
    public const TYPE = 'ftp';

    public function __construct(
        private readonly string $host,
        private readonly string $user,
        private readonly string $pass)
    {
    }

    /**
     * @throws FilesystemException
     */
    public function write(string $path, string $contents): void
    {
        try {
            $adapter = new FtpAdapter(
                FtpConnectionOptions::fromArray([
                    'host' => $this->host,
                    'root' => "/",
                    'username' => $this->user,
                    'password' => $this->pass,
                    'port' => 21,
                    'ssl' => false,
                    'timeout' => 90,
                    'utf8' => false,
                    'passive' => true,
                    'transferMode' => FTP_BINARY,
                    'systemType' => null,
                    'ignorePassiveAddress' => true,
                    'timestampsOnUnixListingsEnabled' => false,
                    'recurseManually' => true
                ])
            );

            $filesystem = new Filesystem($adapter);
            $filesystem->write($path, $contents);
        } catch (Exception $e) {
            throw new RuntimeException($e->getMessage());
        }
    }

    public function supports(string $type): bool
    {
        return self::TYPE === $type;
    }
}
