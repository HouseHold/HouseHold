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

namespace App\Stock\UI\Http\Api\Controller\ProductStock;

use App\Core\Domain\Shared\Exception\FailedToDecodeBodyException;
use App\Core\Domain\Shared\ValueObject\DateTime;
use App\Core\UI\Http\Web\Controller\AbstractController;
use App\Stock\Application\Command\AddProductToStock\AddProductToStockCommand;
use App\Stock\Domain\ProductStock;
use Assert\Assertion;
use Assert\AssertionFailedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class AddToStock extends AbstractController
{
    public function __invoke(Request $request, $id): Response
    {
        try {
            $body = $this->decodeBody();
        } catch (FailedToDecodeBodyException $e) {
            return $e->getResponse();
        }

        try {
            Assertion::keyIsset($body, 'quantity', 'Quantity is not set in body.');
            Assertion::integer($body['quantity'], 0, 'Quantity must be integer.');
            Assertion::greaterThan($body['quantity'], 0, 'Quantity must be over 0.');
        } catch (AssertionFailedException $e) {
            return new Response('', 400, ['x-debug' => $e->getMessage()]);
        }

        /** @var ProductStock|null $stock */
        $stock = $this->getDoctrine()->getRepository(ProductStock::class)->findOneBy(['id' => $id]);
        if (null === $stock) {
            return new Response('', 404);
        }

        $this->run(new AddProductToStockCommand($stock, DateTime::now(), $body['quantity']));

        return new Response('', 204);
    }
}
