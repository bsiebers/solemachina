<?php
class Product {
    public $name;
    public $price;
    public $type;
    public $ingredients;

    public function __construct($name, $price, $type, $ingredients = []) {
        $this->name = $name;
        $this->price = $price;
        $this->type = $type;
        $this->ingredients = $ingredients;
    }
}