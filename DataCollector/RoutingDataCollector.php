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

    /**
     * Constructor for the Router Datacollector
     *
     * @param Router $router The Router Object
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * Collects the Information on the Route
     *
     * @param Request    $request   The Request Object
     * @param Response   $response  The Response Object
     * @param \Exception $exception The Exception
     */
    public function collect(Request $request, Response $response, \Exception $exception = null)
    {
        $collection = $this->router->getRouteCollection();
        $_ressources = $collection->getResources();
        $_routes = $collection->all();

        $routes = array();
        $ressources = array();

        foreach ($_ressources as $ressource) {
            $ressources[] = array(
                'type' => get_class($ressource),
                'path' => $ressource->__toString()
            );
        }


        foreach ($_routes as $routeName => $route) {

            $options = $route->getOptions();
            $defaults = $route->getDefaults();
            $requirements = $route->getRequirements();
            $controller = isset($defaults['_controller']) ? $defaults['_controller'] : 'unknown';
            $routes[$routeName] = array(
                'name' => $routeName,
                'pattern' => $route->getPattern(),
                'controller' => $controller
            );
        }
        ksort($routes);
        $this->data['matchRoute'] = $request->attributes->get('_route');
        $this->data['routes'] = $routes;
        $this->data['ressources'] = $ressources;
    }

    /**
     * Returns the Amount of Routes
     *
     * @return integer Amount of Routes
     */
    public function getRouteCount()
    {
        return count($this->data['routes']);
    }

    /**
     * Returns the Matched Routes Information
     *
     * @return array Matched Routes Collection
     */
    public function getMatchRoute()
    {
        return $this->data['matchRoute'];
    }

    /**
     * Returns the Ressources Information
     *
     * @return array Ressources Information
     */
    public function getRessources()
    {
        return $this->data['ressources'];
    }

    /**
     * Returns the Amount of Ressources
     *
     * @return integer Amount of Ressources
     */
    public function getRessourceCount()
    {
        return count($this->data['ressources']);
    }

    /**
     * Returns all the Routes
     *
     * @return array Route Information
     */
    public function getRoutes()
    {
        return $this->data['routes'];
    }

    /**
     * Returns the Time
     *
     * @return int Time
     */
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
