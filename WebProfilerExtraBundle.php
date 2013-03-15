<?php

namespace Elao\WebProfilerExtraBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

use Elao\WebProfilerExtraBundle\DependencyInjection\Compiler\TwigEngineCompilerPass;

class WebProfilerExtraBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new TwigEngineCompilerPass());
    }
}
