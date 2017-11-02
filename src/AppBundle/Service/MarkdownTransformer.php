<?php
/**
 * Created by PhpStorm.
 * User: cynthia
 * Date: 02/11/2017
 * Time: 09:42
 */

namespace AppBundle\Service;

use Knp\Bundle\MarkdownBundle\MarkdownParserInterface;

/**
 * Class MarkdownTransformer
 * @package AppBundle\Service
 */
class MarkdownTransformer
{
    private $markdownParser;

    /**
     * MarkdownTransformer constructor.
     * @param $markdownParser
     */
    public function __construct(MarkdownParserInterface $markdownParser)
    {
        $this->markdownParser = $markdownParser;
    }

    /**
     * @param $str
     * @return mixed
     */
    public function parse($str)
    {
        return $this->markdownParser
            ->transformMarkdown($str);
    }
}