<?php

namespace PlumeSolution\Async\Managers\Data;

use Exception;
use React\EventLoop\LoopInterface;
use React\Filesystem\Filesystem;
use React\Filesystem\FilesystemInterface;
use React\Filesystem\Node\DirectoryInterface;
use React\Filesystem\Node\FileInterface;

/**
 * Class AsyncFileManager
 * Manage async IO over file
 * @todo add lib when she work o php 8
 */
class AsyncFileManager
{
    /**
     * @var FilesystemInterface
     */
    private FilesystemInterface $filesystem;

    /**
     * AsyncFileManager constructor.
     *
     * @param LoopInterface $eventLoop
     */
    public function __construct(LoopInterface $eventLoop)
    {
        $this->filesystem = Filesystem::create($eventLoop);
    }

    /**
     * @param string $path
     *
     * @return DirectoryInterface
     */
    public function getDirectory(string $path): DirectoryInterface
    {
        return $this->getFilesystem()->dir($path);
    }

    /**
     * Get the internal filesystem for external usage (for using service as Singleton)
     *
     * @return FilesystemInterface
     */
    public function getFilesystem(): FilesystemInterface
    {
        return $this->filesystem;
    }

    /**
     * Write one string or array of string in file
     *
     * @param string         $path
     * @param string | array $write
     * @param string         $right
     */
    public function writeFile(string $path, $write, string $right = 'cwt')
    {
        $this->getFile($path)->open($right)->then(
            function ($stream) use ($write)
            {
                if (is_array($write))
                {
                    foreach ($write as $line)
                    {
                        $stream->write($line);
                    }
                }
                else if (is_string($write))
                {
                    $stream->end($write);
                }
                else
                {
                    throw new Exception('Cannot write file, can only use string or array of string');
                }
            }
        )
        ;
    }

    /**
     * Return a FileInterface for external interaction
     *
     * @param string $path
     *
     * @return FileInterface
     */
    public function getFile(string $path): FileInterface
    {
        return $this->getFilesystem()->file($path);
    }
}
