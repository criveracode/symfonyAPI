<?php

namespace App\Factory;

use App\Entity\Category;
use Zenstruck\Foundry\ModelFactory;


final class CategoryFactory extends ModelFactory
{

    public function __construct()
    {
        parent::__construct();
    }

    protected function getDefaults(): array
    {
        return [
            'name' => self::faker()->sentence(),
        ];
    }

    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Category $category): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Category::class;
    }
}
