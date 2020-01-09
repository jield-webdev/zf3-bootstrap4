<?php
/**
 * Zf3Bootstrap4
 */

namespace Zf3Bootstrap4\View\Helper;

use Laminas\View\Helper\Navigation as LaminasNavigation;
use Zf3Bootstrap4\View\Helper;

/**
 * Navigation
 */
class Navigation extends LaminasNavigation
{
    protected $defaultProxy = 'zf3b4menu';

    protected $defaultPluginManagerHelpers
        = [
            'zf3b4menu'    => Helper\Navigation\Menu::class,
            'ztbmenu'      => Helper\Navigation\Menu::class,
            'ztbsubmenu'   => Helper\Navigation\SubMenu::class,
            'zf3b4submenu' => Helper\Navigation\SubMenu::class,
        ];

    public function getPluginManager(): LaminasNavigation\PluginManager
    {
        $pm = parent::getPluginManager();
        foreach ($this->defaultPluginManagerHelpers as $name => $invokableClass) {
            $pm->setAllowOverride(true);
            $pm->setInvokableClass($name, $invokableClass);
        }

        return $pm;
    }
}
