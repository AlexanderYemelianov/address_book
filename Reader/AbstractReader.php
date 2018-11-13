<?php

abstract class AbstractReader
{
    /**
     * @param $pathToFile
     * @return mixed
     */
    abstract public function getData($pathToFile);
}