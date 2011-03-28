Installation
============

  1. Add this bundle to your src/ dir:

          $ mkdir -p src/Elao
          $ git submodule add git://github.com/Elao/WebProfilerExtraBundle.git src/Elao/WebProfilerExtraBundle

  2. Add the Elao namespace to your autoloader:

          // app/autoload.php
          $loader->registerNamespaces(array(
                'Elao' => __DIR__.'/../src',
                // your other namespaces
          ));

  3. Add this bundle to your application's kernel:

          // app/AppKernel.php
          public function registerBundles()
          {
	
			if ($this->isDebug()) {
			            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
			            $bundles[] = new Elao\WebProfilerExtraBundle\WebProfilerExtraBundle();
			}
          }

  4. Configure the `web_profiler_extra` service in your config:

          # application/config/config.yml
          web_profiler_extra:
              routing:    true
              container:  true
              assetic:    true
              twig:       true

          # application/config/config.xml
          <web_profiler_extra
              routing="true"
              container="true"
              assetic="true"
              twig="true"
          />
  5. Install assets
          $ app/console assets:install web
