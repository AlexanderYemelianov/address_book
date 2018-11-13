<?php

class Mysql {
    /**
     * Table name
     */
    const TABLE_NAME = 'address_book';

    /**
     * Table's columns
     */
    const TABLE_COLUMNS = ['country', 'city', 'street', 'post_code', 'name', 'lastname', 'phone'];

    /**
     * Tables unique values that used for DUPLICATE KEY UPDATE in SQL statement
     */
    const VALUES_TO_UPDATE = ['street', 'name', 'phone'];

    /**
     * MAX number of rows that can be insert into  table during one transaction
     */
    const MAX_BULK = 2;

    /**
     * @var PDO
     */
    private $_pdo;
    /**
     * @var
     */
    private $_statementTemplate;

    /**
     * Mysql constructor.
     * @throws Exception
     */
    public function __construct()
    {
        $this->initDBConnection();
    }

    /**
     * Initiate PDO Connection or throw Exception
     */
    private function initDBConnection()
    {
        try {
            $this->_pdo = new PDO(DbConfig::getDSN(), DbConfig::getUser(), DbConfig::getPassword());
        } catch (Exception $exception) {
            throw new Exception("Can't open the database.");
        }
    }

    /**
     * @return PDO
     */
    private function _getPDO()
    {
        return $this->_pdo;
    }

    /**
     * @return string
     */
    private function _getTableName() {
        return self::TABLE_NAME;
    }

    /**
     * @return string
     */
    private function _prepareColumnsForStatement(){
        return implode(', ', self::TABLE_COLUMNS);
    }

    /**
     * @return string
     */
    private function _prepareValuesForUpdate()
    {
        $result = [];
        foreach (self::VALUES_TO_UPDATE as $value) {
            $result[] = sprintf("%s = VALUES(%s)",$value, $value);
        }
        return implode(', ', $result);
    }

    /**
     * @return string
     */
    private function _getStatementTemplate()
    {
        if (is_null($this->_statementTemplate)) {
            $this->_statementTemplate = "INSERT INTO " . $this->_getTableName() . "(" . $this->_prepareColumnsForStatement()  . ")"
                . " VALUES %s ON DUPLICATE KEY UPDATE " . $this->_prepareValuesForUpdate();
        }
         return $this->_statementTemplate;
    }

    /**
     * @param array $data
     * @return array
     */
    private function _prepareStatements(array $data)
    {
        $statementTemplate = $this->_getStatementTemplate();
        $statements = [];
        $values = [];

        foreach ($data as $value) {
            array_walk($value, array($this, '_quoteValues'));
            $values[] = '(' . implode(', ', $value) . ')';
            if (count($values) === self::MAX_BULK) {
                $statements[] = sprintf($statementTemplate, implode(', ', $values));
                $values = [];
            }
        }
        $statements[] = sprintf($statementTemplate, implode(', ', $values));

        return $statements;
    }

    /**
     * @param array $statements
     * @return void
     * @throws Exception
     */
    private function _save(array $statements)
    {
        foreach ($statements as $statement) {
            $result = $this ->_getPDO()
                            ->prepare($statement)
                            ->execute();
            if(! $result) throw new Exception('Query failed'. PHP_EOL. $statement);
        }
    }

    /**
     * @param $item
     */
    private function _quoteValues(&$item)
    {
        $item = $this->_getPDO()->quote(trim($item));
    }

    /**
     * @param array $data
     * @return Mysql
     * @throws Exception
     */
    public function saveData(array $data)
    {
        $statements = $this->_prepareStatements($data);
        if (count($statements)) {
            $this->_save($statements);
            return $this;
        }
        throw new Exception('Address Data not available');
    }
}

//CREATE TABLE address_book (
//    id INT AUTO_INCREMENT PRIMARY KEY,
//    country VARCHAR(50),
//    city VARCHAR(50),
//    street VARCHAR(100),
//    post_code VARCHAR(10),
//    name VARCHAR(20),
//    lastname VARCHAR(40),
//    phone VARCHAR(20),
//    CONSTRAINT unique_address UNIQUE (country, city, post_code, lastname)
//);