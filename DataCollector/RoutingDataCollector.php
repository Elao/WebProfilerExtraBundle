<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Vincent Bouzeran <vincent.bouzeran@elao.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Elao\WebProfilerExtraBundle\DataCollector;

use Symfony\Component\HttpKernel\KernelInterface;

use Symfony\Component\HttpKernel\DataCollector\DataCollector;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Router;

/**
 * RoutingDataCollector.
 *
 * @author Vincent Bouzeran <vincent.bouzeran@elao.com>
 */
class RoutingDataCollector extends DataCollector
{
    protected $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * {@inheritdoc}
     */
    public function collect(Request $request, Response $response, \Exception $exception = null)
    {
        $collection  = $this->router->getRouteCollection();
        $_ressources = $collection->getResources();
        $_routes     = $collection->all();
        
        $routes     = array();
        $ressources = array();
        
        foreach ($_ressources as $ressource)
        {
            $ressources[] = array(
                'type' => get_class($ressource),
                'path' => $ressource->__toString()
            );
        }
        
        
        foreach ($_routes as $route_name =>  $route)
        {
            
            $options      = $route->getOptions();
            $defaults     = $route->getDefaults();
            $requirements = $route->getRequirements();
            $controller   = isset($defaults['_controller']) ? $defaults['_controller'] : 'unknown';
            $routes[$route_name] = array(
                'name'           => $route_name,
            	'pattern'        => $route->getPattern(),
            	'controller'     => $controller
            );
        }
        ksort($routes);
        $this->data['matchRoute'] = $request->attributes->get('_route');
        $this->data['routes']     = $routes;
        $this->data['ressources'] = $ressources;
    }
    
    public function getRouteCount()
    {
        return count($this->data['routes']);
    }
    
    public function getMatchRoute()
    {
        return $this->data['matchRoute'];
    }
    
    public function getRessources()
    {
        return $this->data['ressources'];
    }
    
    public function getRessourceCount()
    {
        return count($this->data['ressources']);
    }
    
    
    public function getRoutes()
    {
        return $this->data['routes'];
    }
    
    public function getTime()
    {
        $time = 0;
        return $time;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'routing';
    }
}
