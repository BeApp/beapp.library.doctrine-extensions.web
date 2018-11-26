<?php

namespace Beapp\Doctrine\Extension\Functions;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\AST\InputParameter;
use Doctrine\ORM\Query\AST\Literal;
use Doctrine\ORM\Query\AST\PathExpression;
use Doctrine\ORM\Query\Lexer;

/**
 * "MATCH_AGAINST(name, description, 'redeem')"
 *
 * Make a full text search on multiple fields.
 * You must add a FULLTEXT index on the fields used with this function.
 *
 * Forked from <a href="https://xsolve.software/blog/full-text-searching-in-symfony2-2/#comment-3561882305">this blog article</a>.
 */
class MatchAgainstFunction extends FunctionNode
{
    public const MATCH_AGAINST = 'MATCH_AGAINST';

    /** @var PathExpression[] */
    public $columns = [];
    /** @var InputParameter */
    public $needle;
    /** @var Literal|null */
    public $mode;

    /**
     * Parse DQL Function
     * @inheritdoc
     * @throws \Doctrine\ORM\Query\QueryException
     */
    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        do {
            $this->columns[] = $parser->StateFieldPathExpression();
            $parser->match(Lexer::T_COMMA);
        } while ($parser->getLexer()->isNextToken(Lexer::T_IDENTIFIER));

        $this->needle = $parser->InParameter();

        while ($parser->getLexer()->isNextToken(Lexer::T_STRING)) {
            $this->mode = $parser->Literal();
        }

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    /**
     * Get SQL
     *
     * @inheritdoc
     * @throws \Doctrine\ORM\Query\AST\ASTException
     */
    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        $haystack = join(', ', array_map(function (PathExpression $column) use ($sqlWalker) {
            return $column->dispatch($sqlWalker);
        }, $this->columns));

        if (!is_null($this->mode)) {
            // http://disq.us/p/1mwnhz5
            $mode = " " . str_replace("'", "", $this->mode->dispatch($sqlWalker));
        } else {
            $mode = '';
        }

        return "MATCH (" . $haystack . ") AGAINST (" . $this->needle->dispatch($sqlWalker) . $mode . ')';
    }
}
