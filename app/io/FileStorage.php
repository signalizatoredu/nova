<?php

namespace IO
{
    use Encoders\IEncoder;

    class FileStorage
    {
        protected $encoder;
        protected $file;

        public function __construct(IEncoder $encoder, $file)
        {
            $this->encoder = $encoder;
            $this->setFile($file);
        }

        public function getEncoder()
        {
            return $this->encoder;
        }

        public function setFile($file)
        {
            // Check if it's a new file
            if (file_exists($file)) {
                // Check if it's not a file or not readable
                if (!is_file($file) || !is_readable($file) || !is_writable($file)) {
                    throw new \UnexpectedValueException(
                        "The file $file is not read- and writeable.");
                }
            }

            $this->file = $file;
        }

        public function getFile()
        {
            return $this->file;
        }

        public function write($data)
        {
            try {
                $file = fopen($this->file, "wb");
                fwrite($file, pack("CCC",0xEF, 0xBB, 0xBF));
                fwrite($file, $this->encoder->encode($data));
                fclose($file);
            } catch (\Exception $e) {
                throw new \Exception($e->getMessage());
            }
        }

        public function read()
        {
            try {
                return $this->encoder->decode(@file_get_contents($this->file));
            } catch (\Exception $e) {
                throw new \Exception($e->getMessage());
            }
        }
    }
}
