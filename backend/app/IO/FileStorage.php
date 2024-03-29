<?php

namespace Nova\IO;

use Exception;
use UnexpectedValueException;
use SplFileInfo as FileInfo;

use Nova\Encoders\IEncoder;

class FileStorage
{
    protected $encoder;
    protected $file;

    /**
     * Construct a new FileStorage object.
     *
     * @param IEncoder $encoder IEncoder instance to use.
     * @param FileInfo $file File to read/write.
     *
     * @return void
     */
    public function __construct(IEncoder $encoder, FileInfo $file)
    {
        $this->encoder = $encoder;
        $this->setFile($file);
    }

    /**
     * Gets the encoder used.
     *
     * @return IEncoder
     */
    public function getEncoder()
    {
        return $this->encoder;
    }

    /**
     * Sets the file that will be read/write.
     *
     * @throws UnexpectedValueException
     *
     * @param FileInfo $file
     *
     * @return void
     */
    public function setFile(FileInfo $file)
    {
        // Check if it's a new file
        if ($file->getRealpath()) {
            if (!$file->isFile() ||
                !$file->isReadable() ||
                !$file->isWritable()
            ) {
                throw new UnexpectedValueException(
                    "The file $file is not read- and writeable."
                );
            }
        }

        $this->file = $file;
    }

    /**
     * Gets the FileInfo object used.
     *
     * @return FileInfo
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Writes the given data to the file.
     *
     * @throws Exception
     *
     * @param mixed $data
     *
     * @return void
     */
    public function write($data)
    {
        try {

            $file = $this->file->openFile("wb");

            $file->fwrite(pack("CCC", 0xEF, 0xBB, 0xBF));
            $file->fwrite($this->encoder->encode($data));

            $file = null;

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Read data from the file used.
     *
     * @throws Exception
     *
     * @return mixed
     */
    public function read()
    {
        try {

            $data = "";
            $file = $this->file->openFile("r");

            foreach ($file as $line) {
                $data .= $line;
            }

            $file = null;

            return $this->encoder->decode($data);

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
