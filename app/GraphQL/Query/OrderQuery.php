<?php

namespace App\GraphQL\Query;

use App\Models\Cart;
use App\Models\Order;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;


class OrderQuery extends Query
{
    protected $attributes = [
        'name' => 'Order Query',
        'description' => 'A query'
    ];

    public function type()
    {
        return Type::listOf(GraphQL::type('Order'));
    }

    public function args()
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::listOf(Type::int())
            ],
        ];
    }

    public function resolve($root, $args, $context)
    {

        $query = Order::query()
            ->with('status')
            ->with('products')
            ->latest();
        foreach ($args as $key => $value) {
            if (is_array($value))
                $query->whereIn($key, $value);
            else
                $query->where($key, $value);
        }

        return $query->get()
            ->map(function (Order $order) {
                return [
                    'id'             => $order->id,
                    'address'        => $order->address,
                    'time_delivery'  => $order->time_delivery,
                    'status'         => $order->status->name,
                    'products'       => $order->products->map(function (Cart $cart) {
                        return [
                            'product_name'  =>  $cart->product_name,
                            'quantity'      =>  $cart->quantity
                        ];
                    })
                ];
            });
    }
}
