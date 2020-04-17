<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ShopModel extends Model
{
    protected $table = 'shop_user';
    protected  $primaryKey='id';
	protected $guarded = [];
}
