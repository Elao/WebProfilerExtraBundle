<?php

/**
 * This file is part of the Symfony package.
 *
 * Inspired by Zeev Suraski and Z-Ray-Composer
 *
 * (c) Dmitry Maltsev <judgedim@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Elao\WebProfilerExtraBundle\DataCollector;

use Symfony\Component\HttpKernel\DataCollector\DataCollector;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * ComposerDataCollector.
 *
 * @author Dmitry Maltsev <judgedim@gmail.com>
 */
class ComposerDataCollector extends DataCollector
{
    /**
     * @var KernelInterface
     */
    protected $kernel;

    /**
     * @param KernelInterface $kernel
     * @param bool            $displayInWdt True if the shortcut should be displayed
     */
    public function __construct(KernelInterface $kernel, $displayInWdt = true)
    {
        $this->kernel                 = $kernel;
        $this->data['display_in_wdt'] = $displayInWdt;
    }

    /**
     * {@inheritdoc}
     */
    public function collect(Request $request, Response $response, \Exception $exception = null)
    {
        $composerDir = $this->kernel->getRootDir() . '/../vendor/composer';
        $json        = file_get_contents($composerDir . '/installed.json');
        $data        = json_decode($json);
        foreach ($data as $package) {
            $entry             = [
                'name'    => $package->name,
                'version' => $package->version,
                'source'  => $package->source->url,
            ];
            $entry['requires'] = (empty($package->require) ? array() : (array) $package->require);
            if (!empty($package->authors)) {
                $entry['authors'] = $package->authors;
            }
            if (!empty($package->homepage)) {
                $entry['homepage'] = $package->homepage;
            }
            $this->data['packages'][$package->name] = $entry;
        }
    }

    /**
     * Returns an array of collected packages.
     *
     * @return array
     */
    public function getPackages()
    {
        return $this->data['packages'];
    }

    /**
     * Returns the number of collected packages.
     *
     * @return integer
     */
    public function getPackageCount()
    {
        return count($this->data['packages']);
    }

    /**
     * @return bool
     */
    public function getDisplayInWdt()
    {
        return $this->data['display_in_wdt'];
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'composer';
    }
}
