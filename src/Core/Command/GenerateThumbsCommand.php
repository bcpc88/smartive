<?php

namespace BartlomiejCwiertniaRekrutacjaSmartiveapp\Core\Command;

use BartlomiejCwiertniaRekrutacjaSmartiveapp\Core\Message\GenerateThumbsMessage;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\InvalidOptionException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsCommand(name: 'app:generate-thumbs')]
class GenerateThumbsCommand extends Command
{
    private const IMAGE_DEFAULT_WIDTH = 150;
    private const IMAGE_DEFAULT_HEIGHT = null;
    private const IMAGE_ALLOWED_MIME_TYPES = ['image/jpeg', 'image/png', 'image/gif'];
    private const TYPE_ALLOWED_FILESYSTEM = ['ftp', 'local'];

    public function __construct(private MessageBusInterface $bus)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addOption('type', 't', InputOption::VALUE_REQUIRED, 'Type of filesystem to save files.', 'local');
        $this->addArgument('source', InputArgument::REQUIRED, 'Relative path to images source directory.');
        $this->addArgument('target', InputArgument::REQUIRED, 'Relative path to images target directory.');

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $type = $input->getOption('type');
        if (!in_array($type, self::TYPE_ALLOWED_FILESYSTEM)) {
            throw new InvalidOptionException('Option "type" must be one of "ftp", "local".');
        }

        $sourcePath = trim($input->getArgument('source'), DIRECTORY_SEPARATOR);
        if (!is_dir($sourcePath)) {
            throw new InvalidOptionException('Source directory "' . $sourcePath . '" does not exist.');
        }

        $targetPath = trim($input->getArgument('target'), DIRECTORY_SEPARATOR);

        $images = glob(getcwd() . DIRECTORY_SEPARATOR . $sourcePath . DIRECTORY_SEPARATOR . '*.*');
        foreach ($images as $image) {
            if (!in_array($mimetype = mime_content_type($image), self::IMAGE_ALLOWED_MIME_TYPES)) {
                $output->writeln(sprintf('File mimetype "%s" is not allowed.', $mimetype));
                continue;
            }

            $message = new GenerateThumbsMessage(
                sourcePath: $image,
                targetPath: $targetPath . DIRECTORY_SEPARATOR . basename($image),
                width: self::IMAGE_DEFAULT_WIDTH,
                height: self::IMAGE_DEFAULT_HEIGHT,
                type: $type
            );
            $this->bus->dispatch($message);
            $output->writeln("Dispatched: $image");
        }

        return Command::SUCCESS;
    }
}
