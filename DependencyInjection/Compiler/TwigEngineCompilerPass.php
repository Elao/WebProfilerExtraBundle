<?php

namespace Elao\WebProfilerExtraBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class TwigEngineCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasParameter('web_profiler_extra.data_collector.twig.enabled')
            || !$container->getParameter('web_profiler_extra.data_collector.twig.enabled')
        ) {
            return;
        }

        $container->setDefinition(
            'templating.engine.twig.decorated',
            $container->getDefinition('templating.engine.twig')
        );

        $container->setDefinition(
            'templating.engine.twig',
            new Definition(
                '%web_profiler_extra.templating.engine.twig.class%',
                array(
                    new Reference('twig'),
                    new Reference('templating.engine.twig.decorated'),
                    new Reference('web_profiler_extra.data_collector.twig'),
                )
            )
        );

    }
}
