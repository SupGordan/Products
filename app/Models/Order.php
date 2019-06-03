<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Cart;
/**
 * @property mixed address
 * @property mixed time_delivery
 * @property mixed id
 * @property mixed status_id
 */
class Order extends Model
{
    public function status() {
        return $this->hasOne('App\Models\Status', 'id', 'status_id');
    }

    public function products() {
       return $this->hasMany('App\Models\Cart');
    }
}
