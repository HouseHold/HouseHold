<?php

declare(strict_types=1);

/**
 *
 * Household 2019 — NOTICE OF LICENSE
 * This source file is released under commercial license by copyright holders.
 *
 * @copyright 2017-2019 (c) Niko Granö (https://granö.fi)
 * @copyright 2014-2019 (c) IronLions (https://ironlions.fi)
 *
 */

namespace App\Core\Infrastructure;

use App\Core\Domain\Shared\Config\ConfigurationBridge;
use App\Core\Domain\Shared\Config\ConfiguratorInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;

final class CoreExtension extends Extension
{
    public const PARAMETER_KEY = 'core_sys_config';

    public function getAlias(): string
    {
        return 'hh';
    }

    public function getNamespace(): bool
    {
        return false;
    }

    /**
     * Loads a specific configuration.
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configurators = [];
        foreach (get_declared_classes() as $class) {
            if (\in_array(ConfiguratorInterface::class, class_implements($class), true)) {
                $configurators[] = $class;
            }
        }

        // No Configurators Declared.
        if ($configurators === []) {
            return;
        }

        $builder = new TreeBuilder('hh');
        /** @var ConfiguratorInterface $configurator */
        foreach ($configurators as $configurator) {
            $builder = $configurator::configure($builder);
        }

        $configuration = new ConfigurationBridge($builder);
        $c = $this->processConfiguration($configuration, $configs);

        $container->setParameter(self::PARAMETER_KEY, $c);
    }
}
