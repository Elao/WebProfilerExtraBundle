<?php

/*
 *
 * (c) Vincent Bouzeran <vincent.bouzeran@elao.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Elao\WebProfilerExtraBundle\DataCollector;

use Symfony\Component\HttpKernel\DataCollector\DataCollector;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * AsseticDataCollector.
 *
 * @author Vincent Bouzeran <vincent.bouzeran@elao.com>
 */
class TwigDataCollector extends DataCollector
{
    private $twig;

    /**
     * The Constructor for the Twig Datacollector
     *
     * @param \Twig_Environment $twig Twig Enviroment
     */
    public function __construct(\Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * Collect assets information from Assetic Asset Manager
     *
     * @param Request    $request   The Request Object
     * @param Response   $response  The Response Object
     * @param \Exception $exception The Exception
     */
    public function collect(Request $request, Response $response, \Exception $exception = null)
    {
        $filters = array();
        $tests = array();
        $extensions = array();
        $functions = array();
        $operators = array();

        foreach ($this->twig->getExtensions() as $extensionName => $extension) {
            $extensions[] = array(
                'name' => $extensionName,
                'class' => get_class($extension)
            );
            foreach ($extension->getFilters() as $filterName => $filter) {
                $filters[] = array(
                    'name' => $filterName,
                    'call' => $filter->compile(),
                    'extension' => $extensionName
                );
            }

            foreach ($extension->getTests() as $testName => $test) {
                $tests[] = array(
                    'name' => $testName,
                    'call' => $test->compile(),
                    'extension' => $extensionName
                );
            }

            foreach ($extension->getFunctions() as $functionName => $function) {
                $functions[] = array(
                    'name' => $functionName,
                    'call' => $function->compile(),
                    'extension' => $extensionName
                );
            }
        }
        $this->data['extensions'] = $extensions;
        $this->data['tests'] = $tests;
        $this->data['filters'] = $filters;
        $this->data['functions'] = $functions;
    }

    /**
     * Returns the amount of Extensions
     *
     * @return integer Amount of Extensions
     */
    public function getCountextensions()
    {
        return count($this->getExtensions());
    }

    /**
     * Returns the Twig Extensions Information
     *
     * @return array Extension Information
     */
    public function getExtensions()
    {
        return $this->data['extensions'];
    }

    /**
     * Returns the amount of Filters
     *
     * @return integer Amount of Filters
     */
    public function getCountfilters()
    {
        return count($this->getFilters());
    }

    /**
     * Returns the Filter Information
     *
     * @return array Filter Information
     */
    public function getFilters()
    {
        return $this->data['filters'];
    }

    /**
     * Returns the amount of Twig Tests
     *
     * @return integer Amount of Tests
     */
    public function getCounttests()
    {
        return count($this->getTests());
    }

    /**
     * Returns the Tests Information
     *
     * @return array Tests Information
     */
    public function getTests()
    {
        return $this->data['tests'];
    }

    /**
     * Returns the amount of Twig Functions
     *
     * @return integer Amount of Functions
     */
    public function getCountfunctions()
    {
        return count($this->getFunctions());
    }

    /**
     * Returns Twig Functions Information
     *
     * @return array Function Information
     */
    public function getFunctions()
    {
        return $this->data['functions'];
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'twig';
    }
}
