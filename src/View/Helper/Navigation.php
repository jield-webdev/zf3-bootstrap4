<?php
/**
 * Zf3Bootstrap4
 */

namespace Zf3Bootstrap4\View\Helper;

use Zend\View\Helper\Navigation as ZendNavigation;
use Zf3Bootstrap4\View\Helper;

/**
 * Navigation
 */
class Navigation extends ZendNavigation
{
    /**
     * Default proxy to use in {@link render()}
     *
     * @var string
     */
    protected $defaultProxy = 'zf3b4menu';

    /**
     * Default set of helpers to inject into the plugin manager
     *
     * @var array
     */
    protected $defaultPluginManagerHelpers
        = [
            'zf3b4breadcrumbs' => Helper\Navigation\Breadcrumbs::class,
            'zf3b4menu'        => Helper\Navigation\Menu::class,
            'ztbmenu'          => Helper\Navigation\Menu::class,
            'zf3b4submenu'     => Helper\Navigation\SubMenu::class,
            'ztbsubmenu'       => Helper\Navigation\SubMenu::class,
        ];

    /**
     * Retrieve plugin loader for navigation helpers
     *
     * Lazy-loads an instance of Navigation\HelperLoader if none currently
     * registered.
     *
     * @return \Zend\View\Helper\Navigation\PluginManager
     */
    public function getPluginManager(): ZendNavigation\PluginManager
    {
        $pm = parent::getPluginManager();
        foreach ($this->defaultPluginManagerHelpers as $name => $invokableClass) {
            $pm->setAllowOverride(true);
            $pm->setInvokableClass($name, $invokableClass);
        }

        return $pm;
    }


}
