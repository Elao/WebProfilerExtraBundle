<?php

/*
 * (c) Vincent Bouzeran <vincent.bouzeran@elao.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Elao\WebProfilerExtraBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Alias;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\Config\FileLocator;

/**
 * ExtraProfilerExtension is an extension to add debug information to the web profiler:
 * assetic:		Information about assetics assets
 * routing:		Information about loaded routes
 * container:	Information about the container configuration & sevices
 * kernel:		Information about the kernel
 * twig:		Information about Twig
 *
 * @author Vincent Bouzeran <vincent.bouzeran@elao.com>
 */
class WebProfilerExtraExtension extends Extension
{
    protected $resources = array(
        'routing'   => array('file' => 'routing.xml'),
        'container' => array('file' => 'container.xml'),
        'assetic'   => array('file' => 'assetic.xml'),
        'twig'      => array('file' => 'twig.xml')
    );

    /**
     * Wrapper for the doConfigLoad() Method
     *
     * @param array            $configs   Configurations
     * @param ContainerBuilder $container Containerbuilder Object
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        foreach ($configs as $config) {
            $this->doConfigLoad($config, $container);
        }
    }

    /**
     * Loads the Configuration Files which are set to true
     *
     * @param array            $config    Configurations
     * @param ContainerBuilder $container Containerbuilder Object
     */
    protected function doConfigLoad(array $config, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        foreach ($this->resources as $key => $resource) {
            if (isset($config[$key])) {
                if ($config[$key] === true) {
                    $loader->load($resource['file']);
                }
            }
        }
    }

    /**
     * Returns the base path for the XSD files.
     *
     * @return string The XSD base path
     */
    public function getXsdValidationBasePath()
    {
        return __DIR__.'/../Resources/config/schema';
    }

    /**
     * Returns the namespace to be used for this extension (XML namespace).
     *
     * @return string The XML namespace
     */
    public function getNamespace()
    {
        return 'http://www.symfony-project.org/schema/dic/web_profiler_extra';
    }

    /**
     * Returns the recommended alias to use in XML.
     *
     * This alias is also the mandatory prefix to use when using YAML.
     *
     * @return string The alias
     */
    public function getAlias()
    {
        return 'web_profiler_extra';
    }
}
