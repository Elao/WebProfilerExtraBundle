<?php

/*
 * (c) Vincent Bouzeran <vincent.bouzeran@elao.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Elao\WebProfilerExtraBundle\DataCollector;

use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;

/**
 * AsseticDataCollector.
 *
 * @author Vincent Bouzeran <vincent.bouzeran@elao.com>
 */
class AsseticDataCollector extends DataCollector
{
    protected $container;

    /**
     * Constructor for the Assetic Datacollector
     *
     * @param Container $contaier The service container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Collect assets informations from Assetic Asset Manager
     *
     * @param Request    $request   The Request Object
     * @param Response   $response  The Response Object
     * @param \Exception $exception Exception
     */
    public function collect(Request $request, Response $response, \Exception $exception = null)
    {
        $collections = array();

        foreach ($this->getAssetManager()->getNames() as $name) {
            $collection = $this->getAssetManager()->get($name);
            $assets = array();
            $filters = array();

            foreach ($collection->all() as $asset) {
                $assets[] = $asset->getSourcePath();
            }

            foreach ($collection->getFilters() as $filter) {
                $filters[] = get_class($filter);
            }

            $collections[$name] = array(
                'target' => $collection->getTargetPath(),
                'assets' => $assets,
                'filters' => $filters
            );
        }

        $this->data['collections'] = $collections;
    }

    /**
     * Get the Assetic Assetic manager
     *
     * @return LazyAssetManager
     */
    protected function getAssetManager()
    {
        return $this->container->get('assetic.asset_manager');
    }


    /**
     * Calculates the Collection Count
     *
     * @return integer The Amount of the Collection
     */
    public function getCollectionCount()
    {
        return count($this->data['collections']);
    }

    /**
     * Returns the Collection
     *
     * @return array Returns the Collection
     */
    public function getCollections()
    {
        return $this->data['collections'];
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'assetic';
    }
}
