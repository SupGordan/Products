<?php

namespace App\GraphQL\Type;

use Folklore\GraphQL\GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;

class CartType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Cart',
    ];

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::id()
            ],
            'product_name' => [
                'type' => Type::nonNull(Type::string())
            ],
            'quantity' => [
                'type' => Type::nonNull(Type::int())
            ]
        ];
    }
}
