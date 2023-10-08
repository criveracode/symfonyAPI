<?php

namespace App\Factory;

use App\Entity\Post;
use Zenstruck\Foundry\ModelFactory;


final class PostFactory extends ModelFactory
{

    public function __construct()
    {
        parent::__construct();
    }

    protected function getDefaults(): array
    {
        return [
            'body' => self::faker()->text(),
            'category' => CategoryFactory::new(),
            'title' => self::faker()->sentence(),
        ];
    }

    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Post $post): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Post::class;
    }
}
