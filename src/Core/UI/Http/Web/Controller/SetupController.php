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

namespace App\Core\UI\Http\Web\Controller;

use const DIRECTORY_SEPARATOR as DS;
use Doctrine\DBAL\Connection;
use Doctrine\Migrations\Configuration\Configuration;
use Doctrine\Migrations\Finder\GlobFinder;
use Doctrine\Migrations\MigrationRepository;
use Doctrine\Migrations\Migrator;
use Doctrine\Migrations\OutputWriter;
use Doctrine\Migrations\ParameterFormatter;
use Doctrine\Migrations\Provider\SchemaDiffProvider;
use Doctrine\Migrations\Stopwatch;
use Doctrine\Migrations\Version\Executor;
use Doctrine\Migrations\Version\Factory;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Stopwatch\Stopwatch as SymfonyStopwatch;

final class SetupController extends AbstractController
{
    private KernelInterface $kernel;

    public function __construct(
        MessageBusInterface $commandBus,
        MessageBusInterface $queryBus,
        RequestStack $requestStack,
        KernelInterface $kernel
    ) {
        parent::__construct($commandBus, $queryBus, $requestStack);
        $this->kernel = $kernel;
    }

    /**
     * @Route(methods={"GET", "POST"}, name="setup", path="/setup")
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function __invoke(Request $request): Response
    {
        if (false === $this->isConnected()) {
            return new Response('Could not connect database.');
        }

        /** @var Connection $con */
        $con = $this->getDoctrine()->getConnection();
        $config = $this->getDoctrineConfig($con);
        $repo = $this->getDoctrineRepo($con, $config);
        $migration = new Migrator($config, $repo, new OutputWriter(), new Stopwatch(new SymfonyStopwatch()));

        $migrations = [];
        foreach ($repo->getNewVersions() as $key => $val) {
            $migrations[$val] = $repo->getVersion($val)->getMigration()->getDescription();
        }

        if ($request->isMethod('GET')) {
            return $this->returnView(['available' => json_encode($migrations)]);
        }

        $json = json_decode($request->getContent(), true) ?? [];

        try {
            if (!isset($json['version'])) {
                return JsonResponse::create(['error' => 'Missing param version.'], Response::HTTP_BAD_REQUEST);
            }
            $migration->migrate($json['version']);

            return JsonResponse::create(['status' => Response::HTTP_ACCEPTED], Response::HTTP_ACCEPTED);
        } catch (\Throwable $e) {
            return JsonResponse::create(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @throws \Doctrine\DBAL\DBALException
     */
    private function getDoctrineRepo(Connection $con, Configuration $config): MigrationRepository
    {
        $repo = new MigrationRepository(
            $config,
            $con,
            new GlobFinder(),
            new Factory(
                $config,
                new Executor(
                    $config,
                    $con,
                    new SchemaDiffProvider(
                        $con->getSchemaManager(),
                        $con->getDatabasePlatform()
                    ),
                    new OutputWriter(),
                    new ParameterFormatter($con),
                    new Stopwatch(new SymfonyStopwatch())
                )
            )
        );
        $repo->addVersions($config->registerMigrationsFromDirectory($config->getMigrationsDirectory()));

        return $repo;
    }

    private function getDoctrineConfig(Connection $con): Configuration
    {
        $config = new Configuration($con);
        $config->setMigrationsTableName('core_migrations');
        $config->setMigrationsNamespace('App\Migrations');
        $config->setMigrationsDirectory($this->kernel->getProjectDir().DS.'src'.DS.'Migrations');

        return $config;
    }

    private function isConnected(): bool
    {
        return $this->getDoctrine()->getConnection()->connect();
    }
}
