<?php


namespace App\Stock\Domain;


class Product
{
    private string $id;
    private string $name;
    private array $ean;
    private bool $expires;
    private \DateTime $bestBefore;
    private ProductCollection $collection;
}