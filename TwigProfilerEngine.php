<?php

namespace Elao\WebProfilerExtraBundle;

use Symfony\Bundle\FrameworkBundle\Templating\GlobalVariables;
use Symfony\Bundle\TwigBundle\Debug\TimedTwigEngine;
use Symfony\Component\Config\FileLocatorInterface;
use Symfony\Component\Stopwatch\Stopwatch;
use Symfony\Component\Templating\TemplateNameParserInterface;

use Elao\WebProfilerExtraBundle\DataCollector\TwigDataCollector;

class TwigProfilerEngine extends TimedTwigEngine
{
    protected $collector;

    /**
     * {@inheritdoc}
     */
    public function __construct(\Twig_Environment $environment, TemplateNameParserInterface $parser, FileLocatorInterface $locator, GlobalVariables $globals = null, TwigDataCollector $collector, Stopwatch $stopwatch)
    {
        parent::__construct($environment, $parser, $locator, $stopwatch, $globals);

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
