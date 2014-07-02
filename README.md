Elao WebProfilerExtraBundle
============

[![Total Downloads](https://poser.pugx.org/elao/web-profiler-extra-bundle/d/total.png)](https://packagist.org/packages/elao/web-profiler-extra-bundle)



## What is this Symfony2 bundle for ?

It adds in your WebProfiler extra sections :

+ **Routing** : Lists all the routes connected to your application
+ **Container** : Lists all the services available in your container
+ **Twig** : Lists Twig extensions, tests, filters and functions available for your application
+ **Assetic**

![WebProfilerExtraBundle](screen.png "WebProfilerExtraBundle Screenshot")


## Installation

#### If you are working with Symfony >= 2.2

Add this in your `composer.json`

    "require-dev": {
        [...]
        "elao/web-profiler-extra-bundle" : "~2.3@dev"
    },

And run `php composer.phar update elao/web-profiler-extra-bundle`

If you are working with Symfony <= 2.1, prefer the 2.1 branch of this bundle `"elao/web-profiler-extra-bundle" : "dev-2.1"`


#### Register the bundle in your AppKernel (`app/AppKernel.php`)

Most of the time, we need this bundle to be only activated in the `dev` environment

    [...]
    if (in_array($this->getEnvironment(), array('dev', 'test'))) {
        [...]
        $bundles[] = new Elao\WebProfilerExtraBundle\WebProfilerExtraBundle();
    }

#### Activate the different collectors in  `app/config/config_dev.yml`

    web_profiler_extra:
        routing:
            enabled:        true
            display_in_wdt: true
        container:
            enabled:        true
            display_in_wdt: true
        assetic:
            enabled:        true
            display_in_wdt: true
        twig:
            enabled:        true
            display_in_wdt: true
        session:
            enabled:        true
            display_in_wdt: true
            keys_displayed: ['first_sessionKey', 'second_sessionKey']


## Install assets

Install assets by running to have beautiful icons in your debug bar

    $ app/console assets:install web/ --symlink

## Screenshot

![Screenshot](screen.png)
