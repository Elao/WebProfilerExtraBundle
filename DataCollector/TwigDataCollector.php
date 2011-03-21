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
    
    public function __construct(\Twig_Environment $twig)
    {
        $this->twig = $twig;    
    }
    
    /**
     * Collect assets information from Assetic Asset Manager
     */
    public function collect(Request $request, Response $response, \Exception $exception = null)
    {
       $filters     = array();
       $tests       = array();
       $extensions  = array();
       $functions   = array();
       $operators   = array();
       
       foreach ($this->twig->getExtensions() as $extension_name => $extension)
       {
           $extensions[] = array(
                'name'	=> $extension_name,
           		'class' => get_class($extension)
           );
           foreach ($extension->getFilters() as $filter_name => $filter)
           {
               $filters[] = array(
                   'name'       => $filter_name,
                   'call'	    => $filter->compile(),
                   'extension'	=> $extension_name
               );
           }
           
           foreach ($extension->getTests() as $test_name => $test)
           {
               $tests[] = array(
                   'name'		=> $test_name,
                   'call'		=> $test->compile(),
                   'extension'  => $extension_name
               );
           }
           
           foreach ($extension->getFunctions() as $function_name => $function)
           {
               $functions[] = array(
                   'name'		=> $function_name,
                   'call'		=> $function->compile(),
                   'extension'	=> $extension_name
               );
           }
           
       }
       $this->data['extensions'] = $extensions;
       $this->data['tests']      = $tests;
       $this->data['filters']    = $filters;
       $this->data['functions']  = $functions;
    }    

    public function getCountextensions()
    {
        return count($this->getExtensions());
    }
    
    public function getExtensions()
    {
        return $this->data['extensions'];
    }
    
    public function getCountfilters()
    {
        return count($this->getFilters());
    }
    
    public function getFilters()
    {
        return $this->data['filters'];
    }
    
    public function getCounttests()
    {
        return count($this->getTests());
    }
    
    public function getTests()
    {
        return $this->data['tests'];
    }
    
    public function getCountfunctions()
    {
        return count($this->getFunctions());
    }
    
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
