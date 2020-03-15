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

use App\Core\Domain\Shared\Exception\DateTimeException;
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
            Assertion::keyIsset($body, 'price', 'Price is not set in body.');
            /*
             * This need to be done, due javascript leaves decimals out in numbers
             * and when doing toFixed causes it to convert it into string. We check first if
             * it is a float and fallback to int. We do not accept string here. #StrictTypes
             */
            try {
                Assertion::float($body['price'], 0, 'Price must be float.');
            } catch (AssertionFailedException $e) {
                Assertion::integer($body['price'], 0, 'Price must be float.');
                $body['price'] = (float) $body['price'];
            }
            Assertion::greaterThan($body['price'], 0, 'Price must be over 0 or equal.');
        } catch (AssertionFailedException $e) {
            return $this->returnForException($e);
        }

        /** @var ProductStock|null $stock */
        $stock = $this->getDoctrine()->getRepository(ProductStock::class)->findOneBy(['id' => $id]);
        if (null === $stock) {
            return new Response('', 404);
        }

        $date = null;
        if (true === $stock->product->expiring) {
            try {
                Assertion::keyIsset($body, 'bestBefore', 'BestBefore is not set in body.');

                try {
                    $date = DateTime::fromString($body['bestBefore']);
                } catch (DateTimeException $e) {
                    throw new \InvalidArgumentException('BestBefore is not in valid format.');
                }
            } catch (AssertionFailedException | \InvalidArgumentException $e) {
                return $this->returnForException($e);
            }
        }

        $this->run(new AddProductToStockCommand($stock, $date, $body['quantity'], $body['price']));

        return new Response('', 204);
    }
}
