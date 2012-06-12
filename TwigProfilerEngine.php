<?php

namespace Elao\WebProfilerExtraBundle;

use Symfony\Bundle\TwigBundle\TwigEngine;

use Symfony\Bundle\FrameworkBundle\Templating\GlobalVariables;
use Symfony\Component\Templating\TemplateNameParserInterface;
use Symfony\Component\Config\FileLocatorInterface;

use Elao\WebProfilerExtraBundle\DataCollector\TwigDataCollector;

class TwigProfilerEngine extends TwigEngine
{
    protected $collector;

    /**
     * {@inheritdoc}
     */
    public function __construct(\Twig_Environment $environment, TemplateNameParserInterface $parser, FileLocatorInterface $locator, GlobalVariables $globals = null, TwigDataCollector $collector)
    {
        parent::__construct($environment, $parser, $locator, $globals);

        $this->collector = $collector;
    }

    /**
     * {@inheritdoc}
     */
    public function render($name, array $parameters = array())
    {
        $this->collector->collectTemplateData($name, $parameters);

        return parent::render($name, $parameters);
    }
}
