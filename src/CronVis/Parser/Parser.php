<?php


namespace CronVis\Parser;

use CronVis\Util\FileReader;
use CronVis\Util\LineSource;
use CronVis\Util\StringLineSource;

abstract class Parser
{
    /** @var Tokenizer */
    protected $_tokenizer;
    /** @var LineSource */
    protected $_lineSource;
    /** @var array[] */
    protected $_tokens;

    /**
     * @param LineSource $lineSource
     */
    public function __construct(LineSource $lineSource)
    {
        $this->_tokenizer = $this->_getTokenizer();
        $this->_lineSource = $lineSource;
    }

    /**
     * @throws ParseException
     * @return \Generator<array[]>
     */
    public function parseLines()
    {
        $i = 1;
        try {
            foreach ($this->_lineSource->getLines() as $line) {
                yield $this->parseLine($line);
                $i += 1;
            }
        } catch (ParseException $exception) {
            throw new ParseException(
                sprintf('Parse failure on line %d: %s', $i, $exception->getMessage()), 0, $exception
            );
        }
    }

    public function tokenizeLine($line)
    {
        $this->_tokens = $this->_tokenizer->tokenizeLine($line);
    }

    public function parseLine($line)
    {
        $this->tokenizeLine($line);
        return $this->_parseTokens();
    }

    /** @return Tokenizer */
    abstract protected function _getTokenizer();

    /**
     * @return array[]
     */
    abstract protected function _parseTokens();

    /**
     * @param   string   $expressionType
     * @param   string[] $allowedMarkers
     * @param   array    $stopBefore
     * @param   bool     $consumeMarker
     *
     * @return  array
     */
    public function buildSimpleExpression($expressionType, array $allowedMarkers = [], array $stopBefore = [], $consumeMarker = true)
    {
        $token = $consumeMarker
            ? $this->_consume()
            : $this->_peek();

        if (in_array($token[Token::KEY_TOKEN], $allowedMarkers)) {
            return [$expressionType => $this->_combineTokens($stopBefore)];
        }

        $this->_throwUnexpectedTokenException($token);
        return [];
    }

    /**
     * @param   array $until
     *
     * @return  string
     */
    protected function _combineTokens(array $until = [])
    {
        $output = [];
        $until[] = Token::MARK_NULL;

        if ($this->_peek()[Token::KEY_TOKEN] == Token::WHITESPACE) {
            $this->_consume();
        }

        while (!in_array(($this->_peek()[Token::KEY_TOKEN]), $until)) {
            $output[] = $this->_consume()[Token::KEY_CONTENT];
        }

        if ($this->_peek()[Token::KEY_TOKEN] == Token::WHITESPACE) {
            $this->_consume();
        }

        $result = trim(join('', $output));

        return $result;
    }

    /**
     * @return array|null
     */
    protected function _consume()
    {
        $token = array_shift($this->_tokens);

        return $token == null
            ? Token::$NULL_TOKEN
            : $token;
    }

    /**
     * @return array|null
     */
    protected function _peek()
    {
        if (isset($this->_tokens[0])) {
            return $this->_tokens[0];
        }

        return Token::$NULL_TOKEN;
    }

    protected function _throwUnexpectedTokenException($token)
    {
        throw new ParseException(
            sprintf('unexpected token \'%s\' at offset %d.', $token[Token::KEY_TOKEN], $token[Token::KEY_OFFSET])
        );
    }

    public static function fromString($string)
    {
        return new static(new StringLineSource($string));
    }

    public static function fromFile($fileName)
    {
        return new static(new FileReader($fileName));
    }
}
