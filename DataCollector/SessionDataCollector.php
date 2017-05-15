<?php

/**
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Elao\WebProfilerExtraBundle\DataCollector;

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\DependencyInjection\Alias;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;

/**
 * ContainerDataCollector.
 *
 * @author Rémi Le Monnier <remi.lemonnier@gmail.com>
 */
class SessionDataCollector extends DataCollector
{
    protected $kernel;
    protected $container;
    protected $keysDisplayed;

    /**
     * Constructor for the Container Datacollector
     *
     * @param Kernel  $kernel        The Kernel
     * @param boolean $displayInWdt  True if the shortcut should be displayed
     * @param array   $keysDisplayed List of the session keys to display
     */
    public function __construct(Kernel $kernel, $displayInWdt, $keysDisplayed)
    {
        $this->kernel = $kernel;
        $this->container = $kernel->getContainer();
        $this->data['display_in_wdt'] = $displayInWdt;
        $this->keysDisplayed = $keysDisplayed;
    }

    /**
     * Gets the Kernel
     *
     * @return object The Kernel Object
     */
    public function getKernel()
    {
        return $this->kernel;
    }

    /**
     * Collect information about services and parameters from the cached dumped xml container
     *
     * @param Request    $request   The Request Object
     * @param Response   $response  The Response Object
     * @param \Exception $exception The Exception
     */
    public function collect(Request $request, Response $response, \Exception $exception = null)
    {
        $this->data['session']['id'] = $this->container->get('session')->getId();
        $this->data['session']['all'] = $this->container->get('session')->all();
        $this->data['session']['values'] = $this->getKeysDisplayed();
    }

    /**
     * Returns the Services Information
     *
     * @return array Collection of the Services
     */
    public function getSession()
    {
        return $this->data['session'];
    }

    public function getKeysDisplayed()
    {
        $all = $this->container->get('session')->all();
        $arrDisplayed = array();
        foreach ($all as $key => $value) {
            if (in_array($key, $this->keysDisplayed)) {
                $arrDisplayed[$key] = $value;
            }
        }

        return $arrDisplayed;
    }

    public function getDisplayInWdt()
    {
        return $this->data['display_in_wdt'];
    }

    /**
     * Returns the amount of Session var
     *
     * @return integer Amount of Session var
     */
    public function getSessionCount()
    {
        return count($this->data['session']['values']);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'session';
    }
}
