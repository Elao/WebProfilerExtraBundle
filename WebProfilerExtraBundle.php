<?php

namespace Elao\WebProfilerExtraBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class WebProfilerExtraBundle extends Bundle
{
    public function getNamespace()
    {
        return __NAMESPACE__;
    }
    
    public function getPath()
    {
        return strtr(__DIR__, '\\', '/');
    }
}
