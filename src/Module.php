<?php
/**
 * Zf3Bootstrap4
 */

namespace Zf3Bootstrap4;

use Zend\ModuleManager\Feature\ConfigProviderInterface;

/**
 * Module Setup
 */
class Module implements ConfigProviderInterface
{
    /**
     * Get Config
     *
     * @return array
     */
    public function getConfig(): array
    {
        return include __DIR__ . '/../config/module.config.php';
    }
}
