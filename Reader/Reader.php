<?php

/**
 * Class Reader
 */
class Reader
{
    const ALLOWED_FILE_EXTENSIONS = ['csv', 'txt'];

    private $_pathToFile;

    /**
     * @param $pathToFile
     * @return array
     * @throws Exception
     */
    public function process($pathToFile)
    {
        $this->checkFileExists($pathToFile);

        return $this->getReader()->getData($this->getPathToFile());
    }

    /**
     * @return string
     */
    public function getPathToFile()
    {
        return $this->_pathToFile;
    }

    /**
     * @param $pathToFile
     * @throws Exception
     */
    private function checkFileExists($pathToFile)
    {
        if (file_exists($pathToFile)) return $this->setPathToFile($pathToFile);

        throw new Exception("Cannot find a file: " . $pathToFile . PHP_EOL);

    }

    /**
     * @param $extension
     * @throws Exception
     */
    private function isExtensionAllowed($extension)
    {
        if (! in_array($extension, self::ALLOWED_FILE_EXTENSIONS)) throw new Exception("Wrong File extension. File may have such extensions: " .  implode(', ', self::ALLOWED_FILE_EXTENSIONS) . PHP_EOL);
    }

    /**
     * @param $pathToFile
     */
    private function setPathToFile($pathToFile)
    {
        if (is_null($this->_pathToFile))
        {
            $this->_pathToFile = $pathToFile;
        }
    }

    /**
     * @return \AbstractReader
     * @throws Exception
     */
    private function getReader()
    {
        $extension = pathinfo($this->getPathToFile())['extension'];
        $this->isExtensionAllowed($extension);
        $readerClass = ucfirst($extension) . __CLASS__;

        return new $readerClass;
    }
}