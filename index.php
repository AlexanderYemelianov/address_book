<?php

require_once('init.php');

$AddressBookController = new Controller();
$AddressBookController->addToAddressBook('/Users/testuser/Sites/test.txt');


// Task notes
//importScript
//
//.csv
//
//city
//post_code
//country
//name
//lastname
//street
//phone
//
//50 records should be run with one request
//
//WHERE
//
//INSERT INTO ON DUPLICATE KEY
//
//UNQ: post_code, country, city, lastname
//
//- MySQL abstraction (prepare statements)
//
//- Read abstraction (.csv, .txt)