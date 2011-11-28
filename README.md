Installation
============



## deps

            [WebProfilerExtraBundle]
                git=http://github.com/Elao/WebProfilerExtraBundle.git
                target=bundles/Elao/WebProfilerExtraBundle


(add to deps file and run `./bin/vendors install`)




## AppKernel

            //...


            if (in_array($this->getEnvironment(), array('dev', 'test'))) {
                //.. (just add)
                $bundles[] = new Elao\WebProfilerExtraBundle\WebProfilerExtraBundle();
            }

            //...


## Autoloading

            //...

            'Elao'             => __DIR__.'/../vendor/bundles',

            //...


## app/config/config_dev.yml

        web_profiler_extra:
            routing:    true
            container:  true
            assetic:    true
            twig:       true


## Install assets

        $ `app/console assets:install web`
