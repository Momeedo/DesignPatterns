<?php

namespace RefactoringGuru\Builder\Conceptual;

interface Builder
{
    public function producePartA(): void;

    public function producePartB(): void;

    public function producePartC(): void;
}

class ConcreteBuilder implements Builder
{
    private $product;

    public function __construct()
    {
        $this->reset();
    }

    public function reset(): void
    {
        $this->product = new Product();
    }

    public function producePartA(): void
    {
        $this->product->parts[] = "PartA1";
    }

    public function producePartB(): void
    {
        $this->product->parts[] = "PartB1";
    }

    public function producePartC(): void
    {
        $this->product->parts[] = "PartC1";
    }

    public function getProduct(): Product
    {
        $result = $this->product;
        $this->reset();

        return $result;
    }
}

class Product
{
    public $parts = [];

    public function listParts(): void
    {
        echo "Product parts: " . implode(', ', $this->parts) . "\n\n";
    }
}


class Director
{
    private $builder;

    public function setBuilder(Builder $builder): void
    {
        $this->builder = $builder;
    }

    public function buildMinimalViableProduct(): void
    {
        $this->builder->producePartA();
    }

    public function buildFullFeaturedProduct(): void
    {
        $this->builder->producePartA();
        $this->builder->producePartB();
        $this->builder->producePartC();
    }
}

function clientCode(Director $director)
{
    $builder = new ConcreteBuilder();
    $director->setBuilder($builder);

    echo "Standard basic product:\n";
    $director->buildMinimalViableProduct();
    $builder->getProduct()->listParts();

    echo "Standard full featured product:\n";
    $director->buildFullFeaturedProduct();
    $builder->getProduct()->listParts();

    echo "Custom product:\n";
    $builder->producePartA();
    $builder->producePartC();
    $builder->getProduct()->listParts();
}

$director = new Director();
clientCode($director);
