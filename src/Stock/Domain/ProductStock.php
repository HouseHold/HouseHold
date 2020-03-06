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

namespace App\Stock\Domain;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Core\Infrastructure\Api\Filter\BinaryUuidAwareSearchFilter;
use App\Core\Infrastructure\Singletons\MessengerSingleton;
use App\Stock\Application\Query\GetStockBestBefore\GetStockBestBeforeQuery;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface as Id;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity
 * @ORM\Table(name="stock_inventory")
 * @ORM\Cache(usage="READ_WRITE", region="locking")
 * @ApiFilter(SearchFilter::class, properties={"quantity"="exact"})
 * @ApiFilter(BinaryUuidAwareSearchFilter::class, properties={"location"="exact", "product"="exact"})
 * @ApiResource(itemOperations={
 *     "get",
 *     "stock_add"={
 *         "method"="POST",
 *         "path"="/product/stocks/{id}/add",
 *         "controller"="App\Stock\UI\Http\Api\Controller\ProductStock\AddToStock",
 *         "normalization_context"={"groups"={"add"}},
 *         "openapi_context"={
 *             "summary"="Add product into stock.",
 *             "description"="Add specific amount of specific product into stock.",
 *             "responses"={
 *                 "204"={
 *                     "description"="Given quantity of product added to the stock.",
 *                 },
 *                 "400"={
 *                     "description"="Invalid input",
 *                 },
 *                 "404"={
 *                     "description"="Resource not found",
 *                 },
 *             },
 *             "requestBody"={
 *                 "required"=true,
 *                 "content"={
 *                     "application/ld+json"={
 *                         "schema"={
 *                             "type"="object",
 *                              "description"="",
 *                              "properties"={
 *                                 "quantity"={
 *                                     "type"="integer",
 *                                 },
 *                                 "price"={
 *                                     "type"="number",
 *                                 },
 *                             },
 *                         },
 *                     },
 *                 },
 *             },
 *         },
 *     },
 *     "stock_consume"={
 *         "method"="POST",
 *         "path"="/product/stocks/{id}/consume",
 *         "controller"="App\Stock\UI\Http\Api\Controller\ProductStock\ConsumeFromStock",
 *         "normalization_context"={"groups"={"consume"}},
 *         "openapi_context"={
 *             "summary"="Consume product from stock.",
 *             "description"="Consume specific amount of specific product from stock.",
 *             "responses"={
 *                 "204"={
 *                     "description"="Given quantity of product consumed from the stock.",
 *                 },
 *                 "400"={
 *                     "description"="Invalid input",
 *                 },
 *                 "404"={
 *                     "description"="Resource not found",
 *                 },
 *             },
 *             "requestBody"={
 *                 "required"=true,
 *                 "content"={
 *                     "application/ld+json"={
 *                         "schema"={
 *                             "type"="object",
 *                              "description"="",
 *                              "properties"={
 *                                 "quantity"={
 *                                     "type"="integer",
 *                                 },
 *                                 "bestBefore"={
 *                                     "type"="string",
 *                                     "description"="YYYY-MM-DD date or null, if product is set not expiring.",
 *                                     "pattern"="/^([12]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01]))$/",
 *                                     "nullable"=true,
 *                                 },
 *                             },
 *                         },
 *                     },
 *                 },
 *             },
 *         },
 *     },
 * },
 * collectionOperations={
 *     "get",
 *     "stock_init"={
 *         "method"="POST",
 *         "path"="/product/stocks",
 *         "controller"="App\Stock\UI\Http\Api\Controller\ProductStock\InitializeStock",
 *         "openapi_context"={
 *             "summary"="Create stock for product and location.",
 *             "description"="Initialize stock for specific product in specific location.",
 *             "responses"={
 *                 "201"={
 *                     "description"="Created. ProductStock resource response.",
 *                     "content"={
 *                         "application/ld+json"={
 *                             "schema"={
 *                                 "$ref"="#/components/schemas/ProductStock:jsonld"
 *                             },
 *                         },
 *                     },
 *                 },
 *                 "400"={
 *                     "description"="Invalid input",
 *                 },
 *                 "404"={
 *                     "description"="Resource not found",
 *                 },
 *             },
 *             "requestBody"={
 *                 "content"={
 *                     "application/ld+json"={
 *                         "schema"={
 *                             "type"="object",
 *                              "description"="",
 *                              "properties"={
 *                                 "product"={
 *                                     "type"="string",
 *                                 },
 *                                 "location"={
 *                                     "type"="string",
 *                                 },
 *                             },
 *                         },
 *                     },
 *                 },
 *             },
 *         },
 *     },
 * })
 */
class ProductStock
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\Column(type="uuid_binary")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     * @Groups({"read_item"})
     */
    private Id $id;

    /**
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="stocks")
     * @ORM\Cache(usage="READ_WRITE", region="locking")
     */
    public Product $product;

    /**
     * @ORM\ManyToOne(targetEntity="ProductLocation", inversedBy="stocks")
     * @ORM\Cache(usage="READ_WRITE", region="locking")
     */
    public ProductLocation $location;

    /**
     * @var int Quantity of products in stock. Cannot be updated directly.
     * @ORM\Column(type="integer")
     * @Groups({"add", "read_item"})
     */
    public int $quantity = 0;

    /**
     * @var array Array in format where first YYYY-MM-DD and then quantity products on that date
     * @Groups("read_item")
     * @ApiProperty(writable=false, readable=true, openapiContext={
     *     "type"="object",
     *     "items"={},
     *     "additionalProperties"={"type"="string"}
     * })
     *
     * @internal To be used only API output. Values are fetched in controller.
     */
    private array $bestBefore = [];

    public function __construct(Product $product, ProductLocation $location, int $quantity = 0)
    {
        $this->product = $product;
        $this->location = $location;
        $this->quantity = $quantity;
    }

    public function getBestBefore(): array
    {
        // Fetching bestBefore is done here, only to achieve GraphQL support.
        return  MessengerSingleton::ask(new GetStockBestBeforeQuery($this->id))
            ->last(HandledStamp::class)
            ->getResult();
    }

    public function getId(): Id
    {
        return $this->id;
    }
}
