<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * @property mixed order_id
 * @property mixed product_name
 * @property mixed quantity
 */
class Cart extends Model
{
    protected $table = "cart";

    public function orders() {
       return $this->belongsTo('App\Models\Order');
    }
}
