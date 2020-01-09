<?php
/**
 * Zf3Bootstrap4
 */

namespace Zf3Bootstrap4\Navigation\View;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Zf3Bootstrap4\View\Helper\Navigation;

/**
 * Class NavigationHelperFactory
 *
 * @package Zf3Bootstrap4\Navigation\View
 */
final class NavigationHelperFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): Navigation
    {
        $helper = new Navigation();
        $helper->setServiceLocator($container);

        return $helper;
    }
}
