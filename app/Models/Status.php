<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    const NEW_ORDER = 1;
    const ORDER_DELIVERED = 2;
    const ORDER_FINISHED = 3;

    protected $table = 'status';

    public function orders() {
      return  $this->belongsTo('App\Models\Order');
    }
}
