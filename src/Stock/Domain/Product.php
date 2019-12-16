<?php


namespace App\Stock\Domain;


class Product
{
    private string $id;
    public string $name;
    public array $ean;
    public bool $expires;
    public \DateTime $bestBefore;
    public ProductCollection $collection;
}