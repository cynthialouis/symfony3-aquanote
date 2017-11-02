<?php
/**
 * Created by PhpStorm.
 * User: cynthia
 * Date: 02/11/2017
 * Time: 11:14
 */

namespace AppBundle\Twig;


use AppBundle\Service\MarkdownTransformer;

class MarkdownExtension extends \Twig_Extension
{
    /**
     * @var MarkdownTransformer
     */
    private $markdownTransformer;

    /**
     * MarkdownExtension constructor.
     * @param MarkdownTransformer $markdownTransformer
     */
    public function __construct(MarkdownTransformer $markdownTransformer)
    {
        $this->markdownTransformer = $markdownTransformer;
    }


    /**
     * @return array
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('markdownify', array($this, 'parseMarkdown'), [
                'is_safe' => ['html']
            ])
        ];
    }

    /**
     * @param $str
     * @return string
     */
    public function parseMarkdown($str)
    {
        return $this->markdownTransformer->parse($str);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'app_markdown';
    }
}