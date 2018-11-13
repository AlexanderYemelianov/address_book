<?php

/** Error displaying settings */
error_reporting(E_ALL);
ini_set('display_errors', 1);

/** Define Root Path */
define('__ROOT__', dirname(__FILE__));

/**Should be replaced with AutoLoaderClass. And have a better architecture, I suppose.*/
require_once(__ROOT__ . '/Controller.php');

require_once(__ROOT__ . '/Reader/Reader.php');
require_once(__ROOT__ . '/Reader/AbstractReader.php');
require_once(__ROOT__ . '/Reader/CsvReader.php');
require_once(__ROOT__ . '/Reader/TxtReader.php');

require_once(__ROOT__ . '/DbHandler/DbConfig.php');
require_once(__ROOT__ . '/DbHandler/Mysql.php');
