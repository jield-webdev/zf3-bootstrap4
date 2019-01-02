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
    protected $defaultProxy = 'zf3b4menu';

    protected $defaultPluginManagerHelpers
        = [
            'zf3b4menu'    => Helper\Navigation\Menu::class,
            'ztbmenu'      => Helper\Navigation\Menu::class,
            'ztbsubmenu'   => Helper\Navigation\SubMenu::class,
            'zf3b4submenu' => Helper\Navigation\SubMenu::class,
        ];

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
