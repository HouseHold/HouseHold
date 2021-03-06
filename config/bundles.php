<?php

return [
    Symfony\Bundle\FrameworkBundle\FrameworkBundle::class                    => ['all' => true],
    Broadway\Bundle\BroadwayBundle\BroadwayBundle::class                     => ['all' => true],
    Doctrine\Bundle\DoctrineBundle\DoctrineBundle::class                     => ['all' => true],
    Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle::class         => ['all' => true],
    Symfony\Bundle\TwigBundle\TwigBundle::class                              => ['all' => true],
    Symfony\Bundle\WebProfilerBundle\WebProfilerBundle::class                => ['dev' => true, 'test' => true],
    DAMA\DoctrineTestBundle\DAMADoctrineTestBundle::class                    => ['test' => true],
    Symfony\Bundle\SecurityBundle\SecurityBundle::class                      => ['all' => true],
    Lexik\Bundle\JWTAuthenticationBundle\LexikJWTAuthenticationBundle::class => ['all' => true],
    Flagception\Bundle\FlagceptionBundle\FlagceptionBundle::class            => ['all' => true],
    KnpU\OAuth2ClientBundle\KnpUOAuth2ClientBundle::class                    => ['all' => true],
    Symfony\WebpackEncoreBundle\WebpackEncoreBundle::class                   => ['all' => true],
    KevinPapst\AdminLTEBundle\AdminLTEBundle::class                          => ['all' => true],
    Nelmio\CorsBundle\NelmioCorsBundle::class                                => ['all' => true],
    ApiPlatform\Core\Bridge\Symfony\Bundle\ApiPlatformBundle::class          => ['all' => true],
    DH\DoctrineAuditBundle\DHDoctrineAuditBundle::class                      => ['all' => true],
    Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle::class             => ['dev' => true, 'test' => true],
    Snc\RedisBundle\SncRedisBundle::class                                    => ['all' => true],
];
