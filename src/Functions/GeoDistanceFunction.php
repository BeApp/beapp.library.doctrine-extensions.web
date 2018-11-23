<?php

namespace Beapp\Doctrine\Extension\Functions;

use Doctrine\ORM\Query\AST\ArithmeticExpression;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

/**
 * "GEO_DISTANCE(latOrigin, lngOrigin, latDestination, lngDestination)"
 *
 * Compute Geodesic distance between two points, in km
 */
class GeoDistanceFunction extends FunctionNode
{
    private const EARTH_RADIUS = 6371;

    /** @var ArithmeticExpression */
    protected $latOrigin;
    /** @var ArithmeticExpression */
    protected $lngOrigin;
    /** @var ArithmeticExpression */
    protected $latDestination;
    /** @var ArithmeticExpression */
    protected $lngDestination;

    /**
     * Parse DQL Function
     * @inheritdoc
     * @throws \Doctrine\ORM\Query\QueryException
     */
    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $this->latOrigin = $parser->ArithmeticExpression();
        $parser->match(Lexer::T_COMMA);
        $this->lngOrigin = $parser->ArithmeticExpression();
        $parser->match(Lexer::T_COMMA);
        $this->latDestination = $parser->ArithmeticExpression();
        $parser->match(Lexer::T_COMMA);
        $this->lngDestination = $parser->ArithmeticExpression();

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    /**
     * Get SQL
     *
     * ACOS(
     *  SIN(lat1 * PI() / 180) *
     *  SIN(lat2 * PI() / 180) +
     *  COS(lat1 * PI() / 180) *
     *  COS(lat2 * PI() / 180) *
     * COS(lon2 * PI() / 180 - lon1 * PI() / 180)
     * ) * 6371000
     *
     * @inheritdoc
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Doctrine\ORM\Query\AST\ASTException
     */
    public function getSql(SqlWalker $sqlWalker)
    {
        $platform = $sqlWalker->getConnection()->getDatabasePlatform();

        return $platform->getAcosExpression(
                $platform->getSinExpression($this->radian($this->latOrigin->dispatch($sqlWalker))) . ' * ' .
                $platform->getSinExpression($this->radian($this->latDestination->dispatch($sqlWalker))) . ' + ' .
                $platform->getCosExpression($this->radian($this->latOrigin->dispatch($sqlWalker))) . ' * ' .
                $platform->getCosExpression($this->radian($this->latDestination->dispatch($sqlWalker))) . ' * ' .
                $platform->getCosExpression($this->radian($this->lngDestination->dispatch($sqlWalker)) . ' - ' . $this->radian($this->lngOrigin->dispatch($sqlWalker)))
            ) . ' * ' . self::EARTH_RADIUS * 1000;
    }

    private function radian(string $value): string
    {
        return sprintf('RADIAN(%s)', $value);
    }
}
