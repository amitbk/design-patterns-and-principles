<?php

/**
 * The `Abstract Factory` interface declares a set of methods that return
 * different abstract products. These products are called a family and are
 * related by a high-level theme or concept. Products of one family are usually
 * able to collaborate among themselves. A family of products may have several
 * variants, but the products of one variant are incompatible with products of
 * another.
 */
interface FurnitureFactory
{
    public function createSofa(): Sofa;

    public function createChair(): Chair;
}

/**
 * Concrete Factories produce a family of products that belong to a single
 * variant. The factory guarantees that resulting products are compatible. Note
 * that signatures of the Concrete Factory's methods return an abstract product,
 * while inside the method a concrete product is instantiated.
 */
class OfficeStyleFactory implements FurnitureFactory
{
    public function createSofa(): Sofa
    {
        return new OfficeStyleSofa();
    }

    public function createChair(): Chair
    {
        return new OfficeStyleChair();
    }
}

/**
 * Each Concrete Factory has a corresponding product variant.
 */
class HomeStyleFactory implements FurnitureFactory
{
    public function createSofa(): Sofa
    {
        return new HomeStyleSofa();
    }

    public function createChair(): Chair
    {
        return new HomeStyleChair();
    }
}

/**
 * Each distinct product of a product family should have a base interface. All
 * variants of the product must implement this interface.
 */
interface Sofa
{
    public function showSofa(): string;
}

/**
 * Concrete Products are created by corresponding Concrete Factories.
 */
class OfficeStyleSofa implements Sofa
{
    public function showSofa(): string
    {
        return "The result of the product OfficeStyleSofa.";
    }
}

class HomeStyleSofa implements Sofa
{
    public function showSofa(): string
    {
        return "The result of the product HomeStyleSofa.";
    }
}

/**
 * Here's the the base interface of another product. All products can interact
 * with each other, but proper interaction is possible only between products of
 * the same concrete variant.
 */
interface Chair
{
    /**
     * Product B is able to do its own thing...
     */
    public function showChair(): string;

    /**
     * ...but it also can collaborate with the ProductA.
     *
     * The Abstract Factory makes sure that all products it creates are of the
     * same variant and thus, compatible.
     */
    public function packChair(Sofa $collaborator): string;
}

/**
 * Concrete Products are created by corresponding Concrete Factories.
 */
class OfficeStyleChair implements Chair
{
    public function showChair(): string
    {
        return "The result of the product OfficeStyleChair.";
    }

    /**
     * The variant, Product OfficeStyleChair, is only able to work correctly with the variant,
     * Product OfficeStyleSofa. Nevertheless, it accepts any instance of Sofa as
     * an argument.
     */
    public function packChair(Sofa $collaborator): string
    {
        $result = $collaborator->showSofa();

        return "The result of the OfficeStyleChair collaborating with the ({$result})";
    }
}

class HomeStyleChair implements Chair
{
    public function showChair(): string
    {
        return "The result of the product HomeStyleChair.";
    }

    /**
     * The variant, Product HomeStyleChair, is only able to work correctly with the variant,
     * Product HomeStyleSofa. Nevertheless, it accepts any instance of Sofa as
     * an argument.
     */
    public function packChair(Sofa $collaborator): string
    {
        $result = $collaborator->showSofa();

        return "The result of the HomeStyleChair collaborating with the ({$result})";
    }
}

/**
 * The client code works with factories and products only through abstract
 * types: FurnitureFactory and AbstractProduct. This lets you pass any factory or
 * product subclass to the client code without breaking it.
 */
function clientCode(FurnitureFactory $factory)
{
    $sofa = $factory->createSofa();
    $chair = $factory->createChair();

    echo $chair->showChair() . "<br>";
    echo $chair->packChair($sofa) . "<br>";
}

/**
 * The client code can work with any concrete factory class.
 */
echo "Client: Testing client code with the first factory type:<br>";
clientCode(new OfficeStyleFactory());

echo "<br>";

echo "Client: Testing the same client code with the second factory type:<br>";
clientCode(new HomeStyleFactory());
