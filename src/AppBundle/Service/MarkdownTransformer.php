<?php
/**
 * Created by PhpStorm.
 * User: cynthia
 * Date: 02/11/2017
 * Time: 09:42
 */

namespace AppBundle\Service;

/**
 * Class MarkdownTransformer
 * @package AppBundle\Service
 */
class MarkdownTransformer
{
    /**
     * @param $str
     * @return string
     */
    public function parse($str)
    {
        return strtoupper($str);
    }
}