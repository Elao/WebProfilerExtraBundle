<?php

/*
 * (c) Vincent Bouzeran <vincent.bouzeran@elao.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Elao\WebProfilerExtraBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Elao\WebProfilerExtraBundle\DependencyInjection\Compiler\TwigEngineCompilerPass;

/**
 * ExtraProfilerExtension is an extension to add debug information to the web profiler:
 * assetic:		Information about assetics assets
 * routing:		Information about loaded routes
 * container:	Information about the container configuration & sevices
 * twig:		Information about Twig
 *
 * @author Vincent Bouzeran <vincent.bouzeran@elao.com>
 * @author Grégoire Pineau <lyrixx@lyrixx.info>
 */
class WebProfilerExtraExtension extends Extension
{
    private $resources = array(
        'routing'   => 'routing.xml',
        'container' => 'container.xml',
        'assetic'   => 'assetic.xml',
        'twig'      => 'twig.xml',
    );

    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        foreach ($config as $resource => $item) {
            if ($item['enabled']) {
                $loader->load($this->resources[$resource]);
                $container->setParameter('web_profiler_extra.data_collector.'.$resource.'.display_in_wdt', $item['display_in_wdt']);
            }
        }

        if ($config['twig']['enabled']) {
            $container->addCompilerPass(new TwigEngineCompilerPass());
        }
    }
}
