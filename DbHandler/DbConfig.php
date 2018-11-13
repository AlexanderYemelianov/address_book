<?php

class DbConfig
{
    const DSN_WITHOUT_DB_NAME = 'mysql:host=127.0.0.1;dbname=';
    const DB_NAME = 'local_db';
    const USER_NAME = 'root';
    const PASS = 'superroot';

    /**
     * @return string
     */
    public static function getDSN()
    {
        return self::DSN_WITHOUT_DB_NAME . self::DB_NAME;
    }

    /**
     * @return string
     */
    public static function getUser()
    {
        return self::USER_NAME;
    }

    /**
     * @return string
     */
    public static function getPassword()
    {
        return self::PASS;
    }
}

