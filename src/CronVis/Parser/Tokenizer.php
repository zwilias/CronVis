<?php

namespace CronVis\Parser;

class Tokenizer
{
    const KEY_TOKEN     = 0;
    const KEY_CONTENT   = 1;
    const KEY_OFFSET    = 2;

    /** @var Matchable[] */
    protected $_terminals = array();

    /**
     * @param Matchable[] $terminals
     */
    public function setTerminals(array $terminals)
    {
        $this->_terminals = $terminals;
    }

    /**
     * @param string $input
     * @return array[]
     */
    public function tokenizeLine($input)
    {
        $tokens = array();
        $offset = 0;

        while ($offset < strlen($input))
        {
            $token = $this->_match($input, $offset);
            $offset += strlen($token[self::KEY_CONTENT]);
            $tokens[] = $token;
        }

        return $tokens;
    }

    /**
     * @param string $line
     * @param int $offset
     * @return array
     * @throws ParseException
     */
    protected function _match($line, $offset)
    {
        $input = substr($line, $offset);

        foreach ($this->_terminals as $token => $matcher) {
            if (($content = $matcher->matches($input)) !== false) {
                return array(
                    self::KEY_TOKEN     => $token,
                    self::KEY_CONTENT   => $content,
                    self::KEY_OFFSET    => $offset
                );
            }
        }

        throw new ParseException(sprintf("failed to parse after offset %d", $offset));
    }
}