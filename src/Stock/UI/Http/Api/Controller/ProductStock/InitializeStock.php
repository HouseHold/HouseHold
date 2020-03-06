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
use App\Core\UI\Http\Web\Controller\AbstractController;
use App\Stock\Application\Command\InitializeProductStock\InitializeProductStockCommand;
use App\Stock\Domain\Product;
use App\Stock\Domain\ProductLocation;
use App\Stock\Domain\ProductStock;
use Assert\Assertion;
use Assert\AssertionFailedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class InitializeStock extends AbstractController
{
    /**
     * @return Response|ProductStock
     */
    public function __invoke(Request $request)
    {
        try {
            $body = $this->decodeBody();
        } catch (FailedToDecodeBodyException $e) {
            return $e->getResponse();
        }

        try {
            Assertion::keyIsset($body, 'product');
            Assertion::keyIsset($body, 'location');
            Assertion::string($body['product']);
            Assertion::string($body['location']);
        } catch (AssertionFailedException $e) {
            return $this->returnForException($e);
        }

        /**
         * @var Product|null $product
         * @var ProductLocation|null $location
         */
        $product = $this->findOneBy(Product::class, $this->getIdFromIRI($body['product']));
        $location = $this->findOneBy(ProductLocation::class, $this->getIdFromIRI($body['location']));

        try {
            Assertion::notNull($product, 'Product not found.');
            Assertion::notNull($location, 'Location not found.');
        } catch (AssertionFailedException $e) {
            return $this->returnForException($e, 404);
        }

        $stock = null;
        $this->run(
            new InitializeProductStockCommand(
                $product,
                $location,
                function (ProductStock $s) use (&$stock): void {
                    $stock = $s;
                }
            )
        );

        return $stock;
    }
}
