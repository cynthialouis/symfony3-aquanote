<?php
/**
 * Created by PhpStorm.
 * User: cynthia
 * Date: 02/11/2017
 * Time: 09:42
 */

namespace AppBundle\Service;

use Doctrine\Common\Cache\Cache;
use Knp\Bundle\MarkdownBundle\MarkdownParserInterface;

/**
 * Class MarkdownTransformer
 * @package AppBundle\Service
 */
class MarkdownTransformer
{
    /**
     * @var MarkdownParserInterface
     */
    private $markdownParser;

    /**
     * @var Cache
     */
    private $cache;

    /**
     * MarkdownTransformer constructor.
     * @param $markdownParser
     */
    public function __construct(MarkdownParserInterface $markdownParser, Cache $cache)
    {
        $this->markdownParser = $markdownParser;
        $this->cache = $cache;
    }

    /**
     * @param $str
     * @return mixed
     */
    public function parse($str)
    {
        $cache = $this->cache;
        //Make sure the same string doesn't get parsed twice through markdown.
        $key = md5($str);
        if ($cache->contains($key)) {
            return $cache->fetch($key);
        }

        // To fake how slow this could be
        sleep(1);

        $str = $this->markdownParser
            ->transformMarkdown($str);
        $cache->save($key, $str);

        return $str;
    }
}