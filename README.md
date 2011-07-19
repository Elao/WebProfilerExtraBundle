Installation
============

1. Add this bundle to your src/ dir:

        $ mkdir -p src/Elao
        $ git submodule add git://github.com/Elao/WebProfilerExtraBundle.git src/Elao/WebProfilerExtraBundle


2. Add this bundle to your application's kernel:

        // app/AppKernel.php
        public function registerBundles()
        {
            if ($this->isDebug()) {
                $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
                $bundles[] = new Elao\WebProfilerExtraBundle\WebProfilerExtraBundle();
            }
        }


3. Configure the `web_profiler_extra` service in your dev config:

        # application/config/config_dev.yml
        web_profiler_extra:
            routing:    true
            container:  true
            assetic:    true
            twig:       true
        
        # application/config/config_dev.xml
        <web_profiler_extra
            routing="true"
            container="true"
            assetic="true"
            twig="true"
        />


4. Install assets

        $ app/console assets:install web
