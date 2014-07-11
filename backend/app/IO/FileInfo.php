<?php

namespace Nova\IO;

class FileInfo implements IFileInfo
{
    private $fileInfo;

    /**
     * Creates a new FileInfo object
     *
     * @param string filename Path to the file
     * @return object
     */
    public function __construct($filename)
    {
        if (empty($filename)) {
            throw new \Exception("No filename provided.");
        }

        $this->fileInfo = new \SplFileInfo($filename);
    }

    /**
     * Get child directories and files of the current dir
     *
     * @return array
     */
    public function getChildren()
    {
        $children = null;

        if ($this->isDir()) {
            $children = array();
            $subObjects = scandir($this->getRealPath());

            foreach ($subObjects as $child) {
                if ($child != "." && $child != "..") {
                    $realPath = sprintf("%s/%s", $this->getRealPath(), $child);
                    $children[] = new FileInfo($realPath);
                }
            }
        }

        return $children;
    }

    /**
     * Get the extension
     *
     * @return string
     */
    public function getExtension()
    {
        return $this->fileInfo->getExtension();
    }

    /**
     * Get the filename
     *
     * @return string
     */
    public function getFilename()
    {
        return $this->fileInfo->getFilename();
    }

    /**
     * Get the filename
     *
     * @return string
     */
    public function getFilenameWithoutExtension()
    {
        $extension = sprintf(".%s", $this->getExtension());
        return $this->fileInfo->getBasename($extension);
    }

    /**
     * Get the full file path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->fileInfo->getPathname();
    }

    /**
     * Get the real absolute path
     *
     * @return string
     */
    public function getRealPath()
    {
        return $this->fileInfo->getRealPath();
    }

    /**
     * Get FileInfo object for the parent.
     * Returns null if no parent is found.
     *
     * @return object
     */
    public function getParentInfo()
    {
        $path = $this->getParentPath();

        if ($path != null) {
            return new FileInfo($path);
        }

        return null;
    }

    /**
     * Get parent path.
     * Returns null if no parent is found.
     *
     * @return string
     */
    public function getParentPath()
    {
        $path = $this->getPath();
        $parentPath = dirname($path);

        if ($path == $parentPath) {
            return null;
        }

        return $parentPath;
    }

    /**
     * Check if the file exists
     *
     * @return boolean
     */
    public function exists()
    {
        return file_exists($this->getPath());
    }

    /**
     * Check if the file is a directory
     *
     * @return boolean
     */
    public function isDir()
    {
        return $this->fileInfo->isDir();
    }

    /**
     * Check if the file is a file
     *
     * @return boolean
     */
    public function isFile()
    {
        return $this->fileInfo->isFile();
    }

    /**
     * Check if the file is a link
     *
     * @return boolean
     */
    public function isLink()
    {
        return $this->fileInfo->isLink();
    }

    /**
     * Check if the file is executable
     *
     * @return boolean
     */
    public function isExecutable()
    {
        return $this->fileInfo->isExecutable();
    }

    /**
     * Check if the file is readable
     *
     * @return boolean
     */
    public function isReadable()
    {
        return $this->fileInfo->isReadable();
    }

    /**
     * Check if the file is writeable
     *
     * @return boolean
     */
    public function isWriteable()
    {
        return $this->fileInfo->isWriteable();
    }
}
