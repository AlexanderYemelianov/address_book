<?php

class CsvReader extends AbstractReader
{
    /**
     * @param $pathToFile
     * @return array|mixed
     */
    public function getData($pathToFile)
    {
      return  array_map('str_getcsv', file($pathToFile));
    }
}