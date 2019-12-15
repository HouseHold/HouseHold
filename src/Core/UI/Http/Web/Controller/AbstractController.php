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

namespace App\Core\UI\Http\Web\Controller;

use App\Core\Infrastructure\CoreExtension;
use League\Tactician\CommandBus;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
    /**
     * @var RequestStack
     */
    private $requestStack;

    protected function run(object $command): void
    {
        $this->commandBus->handle($command);
    }

    protected function ask(object $query)
    {
        return $this->queryBus->handle($query);
    }

    public function __construct(CommandBus $commandBus, CommandBus $queryBus, RequestStack $requestStack)
    {
        $this->commandBus = $commandBus;
        $this->queryBus = $queryBus;
        $this->requestStack = $requestStack;
    }

    protected function returnView(array $params = [], ?Response $response = null): Response
    {
        $controller = explode('\\', $this->requestStack->getCurrentRequest()->attributes->get('_controller'));
        $controller = str_replace('Controller', '', end($controller));
        $controller = explode('::', $controller);
        $folder = strtolower($controller[0]);
        $file = $controller[1] ?? 'index';
        $module = explode('\\', static::class)[1];

        // @noinspection PhpTemplateMissingInspection
        return $this->render("@$module/$folder/$file.twig", $params, $response);
    }

    protected function getConfig(string $key = '', $default = null)
    {
        $data = $this->getParameter(CoreExtension::PARAMETER_KEY);

        if ('' === $key) {
            return $data;
        }

        if (!\count($data)) {
            return $default;
        }

        if (false !== strpos($key, '.')) {
            $keys = explode('.', $key);
            foreach ($keys as $innerKey) {
                if (!isset($data[$innerKey])) {
                    return $default;
                }

                $data = $data[$innerKey];
            }

            return $data;
        }

        return isset($data[$key]) ? $data[$key] : $default;
    }

    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * @var CommandBus
     */
    private $queryBus;
}
