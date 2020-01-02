<?php

declare(strict_types=1);

/**
 *
 * Household 2020 — NOTICE OF LICENSE
 * This source file is released under commercial license by copyright holders.
 *
 * @copyright 2017-2020 (c) Niko Granö (https://granö.fi)
 * @copyright 2014-2020 (c) IronLions (https://ironlions.fi)
 *
 */

namespace App\Security\Domain\Config;

use App\Core\Domain\Shared\Config\ConfiguratorInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

final class SecurityConfigurator implements ConfiguratorInterface
{
    public const SUPPORTED_OAUTH_PROVIDERS = ['drupal', 'user_pass'];

    public static function configure(TreeBuilder $builder): TreeBuilder
    {
        $builder->getRootNode()
            ->children()
            ->arrayNode('security')->isRequired()
            ->children()
            ->arrayNode('authentication')->isRequired()
            ->children()
            ->arrayNode('oauth')->isRequired()
            ->children()
            ->enumNode('default_provider')->values(self::SUPPORTED_OAUTH_PROVIDERS)->isRequired()->end()
            ->booleanNode('enabled')->isRequired()->end()
            ->arrayNode('providers')->scalarPrototype()->end()->isRequired()->end()
            ->end()
            ->end()
            ->arrayNode('drupal')->isRequired()
            ->children()
            ->arrayNode('scopes')->scalarPrototype()->end()->isRequired()->end()
            ->end()
            ->end()
            ->end()
            ->end();

        return $builder;
    }
}
