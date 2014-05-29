<?php


namespace CronVis\Util;


class FileReader implements LineSource
{
    /** @var string */
    private $_file;

    /**
     * @param string $file
     */
    public function __construct($file)
    {
        $this->_file = $file;
    }

    /**
     * @return \Generator<string>
     */
    public function getLines()
    {
        $fp = fopen($this->_file, 'r');
        try {
            while (!feof($fp)) {
                yield fgets($fp);
            }
        } finally {
            fclose($fp);
        }
    }
}
