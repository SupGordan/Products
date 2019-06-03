<?php

namespace App\GraphQL\Type;

use Folklore\GraphQL\GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;


class OrderType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Order',
        'description' => 'A order'
    ];

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::id())
            ],
            'address' => [
                'type' => Type::nonNull(Type::string())
            ],
            'time_delivery' => [
                'type' => Type::nonNull(Type::string())
            ],
            'status' => [
                'type' => Type::nonNull(Type::string())
            ],
            'products' => [
                'type' => Type::listOf(\GraphQL::type('Cart'))
            ]
        ];
    }
}
