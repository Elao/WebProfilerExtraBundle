<?php

/*
 * (c) Vincent Bouzeran <vincent.bouzeran@elao.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Elao\WebProfilerExtraBundle\DataCollector;

use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;
use Symfony\Component\DependencyInjection\ParameterBag\FrozenParameterBag;

/**
 * ContainerDataCollector.
 *
 * @author Vincent Bouzeran <vincent.bouzeran@elao.com>
 */
class ContainerDataCollector extends DataCollector
{
    protected $kernel;

    public function __construct(Kernel $kernel)
    {
        $this->kernel = $kernel;
    }

    public function getKernel()
    {
        return $this->kernel;
    }
    
    /**
     * {@inheritdoc}
     */
    public function collect(Request $request, Response $response, \Exception $exception = null)
    {
        $kernel = $this->getKernel();
        $container = $kernel->getContainer();
        $_parameters = $container->parameters;        
        $parameters = array();
        
        foreach ($_parameters as $key => $value)
        {
            $service = substr($key, 0, strpos($key, '.'));
            if (!isset($parameters[$service]))
            {
                $parameters[$service] = array();
            }
            $parameters[$service][$key] = $value;
        }
        
        $services   = array();
        $serviceIds = $container->getServiceIds();
        
        $this->data = array();
        
        foreach ($serviceIds as $serviceId)
        {
            $services[$serviceId] = array(
                'service_id'  => $serviceId,
                'class'       => get_class($container->get($serviceId)) 
            );
        }
        ksort($services);
        ksort($parameters);
        $this->data['parameters'] = $parameters;
        
        $this->data['services'] = $services;
    }
    
    public function getParameters()
    {
        return $this->data['parameters'];
    }
    
    public function getServiceCount()
    {
        return count($this->getServices());
    }
    
    public function getServices()
    {
        return $this->data['services'];
    }
    
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'container';
    }
}
