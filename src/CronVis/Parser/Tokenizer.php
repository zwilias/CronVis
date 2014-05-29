<?php

namespace CronVis\Parser;

class Tokenizer
{
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
            $offset += strlen($token[Token::KEY_CONTENT]);
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
                    Token::KEY_TOKEN     => $token,
                    Token::KEY_CONTENT   => $content,
                    Token::KEY_OFFSET    => $offset
                );
            }
        }

        throw new ParseException(sprintf("failed to parse after offset %d", $offset));
    }
}
