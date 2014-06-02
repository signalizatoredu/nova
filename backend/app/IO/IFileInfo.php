<?php

namespace Nova\IO;

interface IFileInfo
{
    /**
     * Creates a new FileInfo object
     *
     * @param string filename Path to the file
     * @return object
     */
    public function __construct($filename);

    /**
     * Get child directories and files of the current dir
     *
     * @return array
     */
    public function getChildren();

    /**
     * Get the extension
     *
     * @return string
     */
    public function getExtension();

    /**
     * Get the filename
     *
     * @return string
     */
    public function getFilename();

    /**
     * Get the filename
     *
     * @return string
     */
    public function getFilenameWithoutExtension();

    /**
     * Get the full file path
     *
     * @return string
     */
    public function getPath();

    /**
     * Get the real absolute path
     *
     * @return string
     */
    public function getRealPath();

    /**
     * Get FileInfo object for the parent
     *
     * @return object
     */
    public function getParentInfo();

    /**
     * Get parent path
     *
     * @return string
     */
    public function getParentPath();

    /**
     * Check if the file is a directory
     *
     * @return boolean
     */
    public function isDir();

    /**
     * Check if the file is a file
     *
     * @return boolean
     */
    public function isFile();

    /**
     * Check if the file is a link
     *
     * @return boolean
     */
    public function isLink();

    /**
     * Check if the file is executable
     *
     * @return boolean
     */
    public function isExecutable();

    /**
     * Check if the file is readable
     *
     * @return boolean
     */
    public function isReadable();

    /**
     * Check if the file is writeable
     *
     * @return boolean
     */
    public function isWriteable();
}
