<?php


class Controller
{
    /**
     * @var Reader
     */
    private $_readerController;

    /**
     * @var Mysql
     */
    private $_dbHandler;

    /**
     * Controller constructor.
     * @throws Exception
     */
    public function __construct()
    {
        $this->_readerController = new Reader;
        $this->_dbHandler = new Mysql;
    }

    /**
     * @return Reader
     */
    private function _getReaderController()
    {
        return $this->_readerController;
    }

    /**
     * @return Mysql
     */
    private function _getDbHadler()
    {
        return $this->_dbHandler;
    }

    /**
     * print Success Message
     */
    private function _successMessage()
    {
        echo 'Address Data Saved' . PHP_EOL;
    }

    /**
     * @param $pathToFile
     * @throws Exception
     */
    public function addToAddressBook($pathToFile)
    {
        $data = $this->_getReaderController()->process($pathToFile);
        try {
            $this->_getDbHadler()->saveData($data);
            $this->_successMessage();
        } catch (Exception $exception){
            echo $exception->getMessage() . PHP_EOL;
        }
    }

}