Installation
============

## Deps

Add `elao/web-profiler-extra-bundle` to your `composer.json`

```
"require": {
    "elao/web-profiler-extra-bundle": "dev-master"
},
```

Then run:

```
composer update elao/web-profiler-extra-bundle
```

Or directly run:

```
composer require elao/web-profiler-extra-bundle
```

## AppKernel

```
//...

if (in_array($this->getEnvironment(), array('dev', 'test'))) {
    //.. (just add)
    $bundles[] = new Elao\WebProfilerExtraBundle\WebProfilerExtraBundle();
}

//...
```

## app/config/config_dev.yml

```
web_profiler_extra:
    routing:    true
    container:  true
    assetic:    true
    twig:       true
```

## Install assets

```
$ app/console assets:install web
```
