<?php


namespace App\Stock\Domain;


class ProductCollection
{
    private string $id;
    public string $name;
    public ProductCategory $category;
}