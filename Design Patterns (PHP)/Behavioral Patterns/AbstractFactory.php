<?php

interface CarFactory
{
    public function createProductA(): AbstractProductA;
    public function createProductB(): AbstractProductB;
}


class MercedesFactory implements CarFactory
{
    public function createProductA(): AbstractProductA
    {
        return new CarProductA1();
    }

    public function createProductB(): AbstractProductB
    {
        return new CarProductB1();
    }
}


class BMWFactory implements CarFactory
{
    public function createProductA(): AbstractProductA
    {
        return new CarProductA2();
    }

    public function createProductB(): AbstractProductB
    {
        return new CarProductB2();
    }
}


interface AbstractProductA
{
    public function usefulFunctionA(): string;
}


class CarProductA1 implements AbstractProductA
{
    public function usefulFunctionA(): string
    {
        return "The result of the product A1.";
    }
}

class CarProductA2 implements AbstractProductA
{
    public function usefulFunctionA(): string
    {
        return "The result of the product A2.";
    }
}

interface AbstractProductB
{
    public function usefulFunctionB(): string;
    public function anotherUsefulFunctionB(AbstractProductA $collaborator): string;
}

class CarProductB1 implements AbstractProductB
{
    public function usefulFunctionB(): string
    {
        return "The result of the product B1.";
    }

    public function anotherUsefulFunctionB(AbstractProductA $collaborator): string
    {
        $result = $collaborator->usefulFunctionA();

        return "The result of the B1 collaborating with the ({$result})";
    }
}

class CarProductB2 implements AbstractProductB
{
    public function usefulFunctionB(): string
    {
        return "The result of the product B2.";
    }

    public function anotherUsefulFunctionB(AbstractProductA $collaborator): string
    {
        $result = $collaborator->usefulFunctionA();

        return "The result of the B2 collaborating with the ({$result})";
    }
}

function clientCode(CarFactory $factory)
{
    $productA = $factory->createProductA();
    $productB = $factory->createProductB();

    echo $productB->usefulFunctionB() . "\n";
    echo $productB->anotherUsefulFunctionB($productA) . "\n";
}

echo "Client: Testing client code with the first factory type:\n";
clientCode(new MercedesFactory());

echo "\n";

echo "Client: Testing the same client code with the second factory type:\n";
clientCode(new BMWFactory());
