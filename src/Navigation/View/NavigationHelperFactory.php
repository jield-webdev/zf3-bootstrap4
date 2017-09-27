<?php
/**
 * Zf3Bootstrap4
 */

namespace Zf3Bootstrap4\Navigation\View;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zf3Bootstrap4\View\Helper\Navigation;

/**
 * Class NavigationHelperFactory
 *
 * @package ZfcTwitterBootstrap\Navigation\View
 */
class NavigationHelperFactory implements FactoryInterface
{
    /**
     * Create and return a navigation helper instance. (v3)
     *
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param null|array $options
     * @return Navigation
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): Navigation
    {
        $helper = new Navigation();
        $helper->setServiceLocator($container);

        return $helper;
    }

}
