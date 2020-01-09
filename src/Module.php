<?php
/**
 * Zf3Bootstrap4
 */

namespace Zf3Bootstrap4;

use Laminas\ModuleManager\Feature\ConfigProviderInterface;

/**
 * Class Module
 *
 * @package Zf3Bootstrap4
 */
final class Module implements ConfigProviderInterface
{
    public function getConfig(): array
    {
        return include __DIR__ . '/../config/module.config.php';
    }
}
