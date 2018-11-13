<?php


class TxtReader extends AbstractReader
{
    /**
     * Delimiter that used in file
     */
    const DELIMITER = ',';

    /**
     * @param $pathToFile
     * @return array|mixed
     */
    public function getData($pathToFile)
    {
        return $this->parseData(file($pathToFile));
    }

    /**
     * @param array $data
     * @return array
     */
    private function parseData(array $data)
    {
        $result = [];
        foreach ($data as $row) {
            $result[] = explode(self::DELIMITER, $row);
        }
        return $result;
    }
}